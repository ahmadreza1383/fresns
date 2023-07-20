<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Api\Http\Controllers;

use App\Fresns\Api\Http\DTO\NotificationDTO;
use App\Fresns\Api\Http\DTO\NotificationListDTO;
use App\Fresns\Api\Services\CommentService;
use App\Fresns\Api\Services\GroupService;
use App\Fresns\Api\Services\HashtagService;
use App\Fresns\Api\Services\PostService;
use App\Fresns\Api\Services\UserService;
use App\Helpers\CacheHelper;
use App\Helpers\DateHelper;
use App\Helpers\InteractionHelper;
use App\Helpers\LanguageHelper;
use App\Helpers\PluginHelper;
use App\Helpers\PrimaryHelper;
use App\Models\Notification;
use App\Utilities\ArrUtility;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // list
    public function list(Request $request)
    {
        $dtoRequest = new NotificationListDTO($request->all());

        $langTag = $this->langTag();
        $timezone = $this->timezone();
        $authUserId = $this->user()->id;

        $typeArr = array_filter(explode(',', $dtoRequest->types));

        $notificationQuery = Notification::with('actionUser')->where('user_id', $authUserId);

        $notificationQuery->when($typeArr, function ($query, $value) {
            $query->whereIn('type', $value);
        });

        if (isset($dtoRequest->status)) {
            $notificationQuery->where('is_read', $dtoRequest->status);
        }

        $notifications = $notificationQuery->latest()->paginate($dtoRequest->pageSize ?? 15);

        $userService = new UserService();
        $groupService = new GroupService();
        $hashtagService = new HashtagService();
        $postService = new PostService();
        $commentService = new CommentService();

        // actionUser filter
        $actionUserFilterKeys = $dtoRequest->userWhitelistKeys ?? $dtoRequest->userBlacklistKeys;
        $actionUserFilter = [
            'type' => $dtoRequest->userWhitelistKeys ? 'whitelist' : 'blacklist',
            'keys' => array_filter(explode(',', $actionUserFilterKeys)),
        ];

        // actionInfo user filter
        $filterKeys = $dtoRequest->whitelistKeys ?? $dtoRequest->blacklistKeys;
        $filter = [
            'type' => $dtoRequest->whitelistKeys ? 'whitelist' : 'blacklist',
            'keys' => array_filter(explode(',', $filterKeys)),
        ];

        $notificationList = [];
        foreach ($notifications as $notification) {
            $actionUser = null;
            if ($notification->action_user_id) {
                $actionUser = $notification->action_is_anonymous ? InteractionHelper::fresnsUserSubstitutionProfile() : $userService->userData($notification?->actionUser, 'list', $langTag, $timezone, $authUserId);
            }

            // actionUser filter
            if ($actionUserFilter['keys'] && $actionUser) {
                $actionUser = ArrUtility::filter($actionUser, $actionUserFilter['type'], $actionUserFilter['keys']);
            }

            $contentFsid = match ($notification->type) {
                Notification::TYPE_COMMENT => PrimaryHelper::fresnsModelById('comment', $notification?->action_content_id)?->cid,
                Notification::TYPE_QUOTE => PrimaryHelper::fresnsModelById('post', $notification?->action_content_id)?->pid,
                default => null,
            };

            $item['id'] = $notification->id;
            $item['type'] = $notification->type;
            $item['content'] = $notification->is_multilingual ? LanguageHelper::fresnsLanguageByTableId('notifications', 'content', $notification->id, $langTag) : $notification->content;
            $item['isMarkdown'] = (bool) $notification->is_markdown;
            $item['isMention'] = (bool) $notification->is_mention;
            $item['isAccessPlugin'] = (bool) $notification->is_access_plugin;
            $item['pluginUrl'] = PluginHelper::fresnsPluginUrlByFskey($notification->plugin_fskey);
            $item['actionUser'] = $actionUser;
            $item['actionUserIsAnonymous'] = (bool) $notification->action_is_anonymous;
            $item['actionType'] = $notification->action_type;
            $item['actionObject'] = $notification->action_object;
            $item['actionInfo'] = null;
            $item['contentFsid'] = $contentFsid;
            $item['datetime'] = DateHelper::fresnsDateTimeByTimezone($notification->created_at, $timezone, $langTag);
            $item['datetimeFormat'] = DateHelper::fresnsFormatDateTime($notification->created_at, $timezone, $langTag);
            $item['timeAgo'] = DateHelper::fresnsHumanReadableTime($notification->created_at, $langTag);
            $item['readStatus'] = (bool) $notification->is_read;

            if ($notification->action_object && $notification->action_id) {
                $actionInfo = match ($notification->action_object) {
                    Notification::ACTION_OBJECT_USER => $userService->userData($notification?->user, 'list', $langTag, $timezone, $authUserId),
                    Notification::ACTION_OBJECT_GROUP => $groupService->groupData($notification?->group, $langTag, $timezone, $authUserId),
                    Notification::ACTION_OBJECT_HASHTAG => $hashtagService->hashtagData($notification?->hashtag, $langTag, $timezone, $authUserId),
                    Notification::ACTION_OBJECT_POST => $postService->postData($notification?->post, 'list', $langTag, $timezone, $authUserId),
                    Notification::ACTION_OBJECT_COMMENT => $commentService->commentData($notification?->comment, 'list', $langTag, $timezone, $authUserId),
                    Notification::ACTION_OBJECT_POST_LOG => $postService->postLogData($notification?->postLog, 'list', $langTag, $timezone),
                    Notification::ACTION_OBJECT_COMMENT_LOG => $commentService->commentLogData($notification?->commentLog, 'list', $langTag, $timezone),
                    Notification::ACTION_OBJECT_EXTEND => $notification?->extend->getExtendInfo($langTag),
                    default => null,
                };

                // actionInfo user filter
                if ($filter['keys'] && $actionInfo) {
                    $actionInfo = ArrUtility::filter($actionInfo, $filter['type'], $filter['keys']);
                }

                $item['actionInfo'] = $actionInfo;
            }

            $notificationList[] = $item;
        }

        return $this->fresnsPaginate($notificationList, $notifications->total(), $notifications->perPage());
    }

    // markAsRead
    public function markAsRead(Request $request)
    {
        $dtoRequest = new NotificationDTO($request->all());

        $authUser = $this->user();

        if ($dtoRequest->type == 'all') {
            Notification::where('user_id', $authUser->id)->when($dtoRequest->notificationType, function ($query, $value) {
                $query->where('type', $value);
            })->where('is_read', 0)->update([
                'is_read' => 1,
            ]);
        } else {
            $idArr = array_filter(explode(',', $dtoRequest->notificationIds));

            Notification::where('user_id', $authUser->id)->whereIn('id', $idArr)->where('is_read', 0)->update([
                'is_read' => 1,
            ]);
        }

        CacheHelper::forgetFresnsKey("fresns_api_user_panel_notifications_{$authUser->uid}", 'fresnsUsers');

        return $this->success();
    }

    // delete
    public function delete(Request $request)
    {
        $dtoRequest = new NotificationDTO($request->all());

        $authUser = $this->user();

        if ($dtoRequest->type == 'all') {
            Notification::where('user_id', $authUser->id)->where('type', $dtoRequest->notificationType)->delete();
        } else {
            $idArr = array_filter(explode(',', $dtoRequest->notificationIds));

            Notification::where('user_id', $authUser->id)->whereIn('id', $idArr)->delete();
        }

        CacheHelper::forgetFresnsKey("fresns_api_user_panel_notifications_{$authUser->uid}", 'fresnsUsers');

        return $this->success();
    }
}
