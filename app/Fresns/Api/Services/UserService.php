<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Api\Services;

use App\Exceptions\ApiException;
use App\Helpers\CacheHelper;
use App\Helpers\ConfigHelper;
use App\Helpers\DateHelper;
use App\Helpers\InteractionHelper;
use App\Helpers\PrimaryHelper;
use App\Models\ArchiveUsage;
use App\Models\ExtendUsage;
use App\Models\File;
use App\Models\Mention;
use App\Models\OperationUsage;
use App\Models\User;
use App\Utilities\ArrUtility;
use App\Utilities\ConfigUtility;
use App\Utilities\ContentUtility;
use App\Utilities\ExtendUtility;
use App\Utilities\InteractionUtility;
use App\Utilities\PermissionUtility;
use App\Utilities\SubscribeUtility;

class UserService
{
    public function userData(?User $user, string $type, string $langTag, ?string $timezone = null, ?int $authUserId = null)
    {
        if (! $user) {
            return InteractionHelper::fresnsUserSubstitutionProfile('deactivate');
        }

        $cacheKey = "fresns_api_user_{$user->uid}_{$langTag}";
        $cacheTag = 'fresnsUsers';

        $userData = CacheHelper::get($cacheKey, $cacheTag);

        if (empty($userData)) {
            $userProfile = $user->getUserProfile();
            $userMainRole = $user->getUserMainRole($langTag);

            $userProfile['nickname'] = ContentUtility::replaceBlockWords('user', $userProfile['nickname']);
            $userProfile['bio'] = ContentUtility::replaceBlockWords('user', $userProfile['bio']);
            $userProfile['birthday'] = DateHelper::fresnsFormatConversion($userProfile['birthday'], $langTag);

            $bioConfig = ConfigHelper::fresnsConfigByItemKeys([
                'bio_support_mention',
                'bio_support_link',
                'bio_support_hashtag',
            ]);
            $bioHtml = htmlentities($userProfile['bio']);
            if ($bioConfig['bio_support_mention']) {
                $bioHtml = ContentUtility::replaceMention($bioHtml, Mention::TYPE_USER, $user->id);
            }
            if ($bioConfig['bio_support_link']) {
                $bioHtml = ContentUtility::replaceLink($bioHtml);
            }
            if ($bioConfig['bio_support_hashtag']) {
                $bioHtml = ContentUtility::replaceHashtag($bioHtml);
            }
            $userProfile['bioHtml'] = ContentUtility::replaceSticker($bioHtml);

            $item['stats'] = UserService::getUserStats($user, 'list', $langTag);
            $item['archives'] = ExtendUtility::getArchives(ArchiveUsage::TYPE_USER, $user->id, $langTag);
            $item['operations'] = ExtendUtility::getOperations(OperationUsage::TYPE_USER, $user->id, $langTag);
            $item['extends'] = ExtendUtility::getContentExtends(ExtendUsage::TYPE_USER, $user->id, $langTag);
            $item['roles'] = PermissionUtility::getUserRoles($user->id, $langTag);

            if ($item['operations']['diversifyImages']) {
                $decorate = ArrUtility::pull($item['operations']['diversifyImages'], 'code', 'decorate', false);
                $verifiedIcon = ArrUtility::pull($item['operations']['diversifyImages'], 'code', 'verified', false);

                $userProfile['decorate'] = $decorate['imageUrl'] ?? null;
                $userProfile['verifiedIcon'] = $verifiedIcon['imageUrl'] ?? null;
            }

            $userData = array_merge($userProfile, $userMainRole, $item);

            $cacheTime = CacheHelper::fresnsCacheTimeByFileType(File::TYPE_IMAGE);
            CacheHelper::put($userData, $cacheKey, $cacheTag, null, $cacheTime);
        }

        // archives
        if ($user->id != $authUserId && $userData['archives']) {
            $archives = [];
            foreach ($userData['archives'] as $archive) {
                $item = $archive;
                $item['value'] = $archive['isPrivate'] ? null : $archive['value'];

                $archives[] = $item;
            }

            $userData['archives'] = $archives;
        }

        $userData['stats'] = UserService::getUserStats($user, $type, $langTag, $authUserId);

        $interactionConfig = InteractionHelper::fresnsUserInteraction($langTag);
        $interactionStatus = InteractionUtility::getInteractionStatus(InteractionUtility::TYPE_USER, $user->id, $authUserId);
        $userData['interaction'] = array_merge($interactionConfig, $interactionStatus);

        SubscribeUtility::notifyViewContent('user', $user->uid, $type, $authUserId);

        $conversationPermInt = PermissionUtility::checkUserConversationPerm($user->id, $authUserId, $langTag);
        $userData['conversation'] = [
            'status' => ($conversationPermInt != 0) ? false : true,
            'code' => $conversationPermInt,
            'message' => ConfigUtility::getCodeMessage($conversationPermInt, 'Fresns', $langTag),
        ];

        $result = UserService::handleUserDate($userData, $timezone, $langTag);

        // filter
        $filterKeys = \request()->get('whitelistKeys') ?? \request()->get('blacklistKeys');
        $filter = [
            'type' => \request()->get('whitelistKeys') ? 'whitelist' : 'blacklist',
            'keys' => array_filter(explode(',', $filterKeys)),
        ];

        if (empty($filter['keys'])) {
            return $result;
        }

        $currentRouteName = \request()->route()->getName();
        $filterRouteList = [
            'api.account.wallet.logs',
            'api.user.list',
            'api.user.detail',
            'api.user.followers.you.follow',
            'api.user.interaction',
            'api.group.interaction',
            'api.hashtag.interaction',
            'api.post.interaction',
            'api.comment.interaction',
            'api.conversation.list',
            'api.conversation.detail',
            'api.conversation.messages',
            'api.common.file.users',
            'api.post.users',
            'api.post.quotes',
        ];

        if (! in_array($currentRouteName, $filterRouteList)) {
            return $result;
        }

        return ArrUtility::filter($result, $filter['type'], $filter['keys']);
    }

    // get user stats
    public static function getUserStats(User $user, string $type, string $langTag, ?int $authUserId = null)
    {
        if ($type == 'list') {
            $cacheKey = "fresns_api_user_stats_{$user->uid}";
            $cacheTag = 'fresnsUsers';

            $stats = CacheHelper::get($cacheKey, $cacheTag);
            if (empty($stats)) {
                $stats = $user->getUserStats($langTag);

                CacheHelper::put($stats, $cacheKey, $cacheTag, 10, now()->addMinutes(10));
            }
        } else {
            $stats = $user->getUserStats($langTag);
        }

        if ($user->id === $authUserId) {
            $statConfig = ConfigHelper::fresnsConfigByItemKeys([
                'user_liker_count', 'user_disliker_count', 'user_follower_count', 'user_blocker_count',
                'my_liker_count', 'my_disliker_count', 'my_follower_count', 'my_blocker_count',
            ], $langTag);

            if (! $statConfig['user_liker_count']) {
                $stats['likeMeCount'] = $statConfig['my_liker_count'] ? $stats['likeMeCount'] : null;
            }

            if (! $statConfig['user_disliker_count']) {
                $stats['dislikeMeCount'] = $statConfig['my_disliker_count'] ? $stats['dislikeMeCount'] : null;
            }

            if (! $statConfig['user_follower_count']) {
                $stats['followMeCount'] = $statConfig['my_follower_count'] ? $stats['followMeCount'] : null;
            }

            if (! $statConfig['user_blocker_count']) {
                $stats['blockMeCount'] = $statConfig['my_blocker_count'] ? $stats['blockMeCount'] : null;
            }
        } else {
            $statConfig = ConfigHelper::fresnsConfigByItemKeys([
                'it_posts', 'it_comments',
                'it_like_users', 'it_like_groups', 'it_like_hashtags', 'it_like_posts', 'it_like_comments',
                'it_dislike_users', 'it_dislike_groups', 'it_dislike_hashtags', 'it_dislike_posts', 'it_dislike_comments',
                'it_follow_users', 'it_follow_groups', 'it_follow_hashtags', 'it_follow_posts', 'it_follow_comments',
                'it_block_users', 'it_block_groups', 'it_block_hashtags', 'it_block_posts', 'it_block_comments',

                'user_liker_count', 'user_disliker_count', 'user_follower_count', 'user_blocker_count',
            ], $langTag);

            $stats['likeUserCount'] = $statConfig['it_like_users'] ? $stats['likeUserCount'] : null;
            $stats['likeGroupCount'] = $statConfig['it_like_groups'] ? $stats['likeGroupCount'] : null;
            $stats['likeHashtagCount'] = $statConfig['it_like_hashtags'] ? $stats['likeHashtagCount'] : null;
            $stats['likePostCount'] = $statConfig['it_like_posts'] ? $stats['likePostCount'] : null;
            $stats['likeCommentCount'] = $statConfig['it_like_comments'] ? $stats['likeCommentCount'] : null;

            $stats['dislikeUserCount'] = $statConfig['it_dislike_users'] ? $stats['dislikeUserCount'] : null;
            $stats['dislikeGroupCount'] = $statConfig['it_dislike_groups'] ? $stats['dislikeGroupCount'] : null;
            $stats['dislikeHashtagCount'] = $statConfig['it_dislike_hashtags'] ? $stats['dislikeHashtagCount'] : null;
            $stats['dislikePostCount'] = $statConfig['it_dislike_posts'] ? $stats['dislikePostCount'] : null;
            $stats['dislikeCommentCount'] = $statConfig['it_dislike_comments'] ? $stats['dislikeCommentCount'] : null;

            $stats['followUserCount'] = $statConfig['it_follow_users'] ? $stats['followUserCount'] : null;
            $stats['followGroupCount'] = $statConfig['it_follow_groups'] ? $stats['followGroupCount'] : null;
            $stats['followHashtagCount'] = $statConfig['it_follow_hashtags'] ? $stats['followHashtagCount'] : null;
            $stats['followPostCount'] = $statConfig['it_follow_posts'] ? $stats['followPostCount'] : null;
            $stats['followCommentCount'] = $statConfig['it_follow_comments'] ? $stats['followCommentCount'] : null;

            $stats['blockUserCount'] = $statConfig['it_block_users'] ? $stats['blockUserCount'] : null;
            $stats['blockGroupCount'] = $statConfig['it_block_groups'] ? $stats['blockGroupCount'] : null;
            $stats['blockHashtagCount'] = $statConfig['it_block_hashtags'] ? $stats['blockHashtagCount'] : null;
            $stats['blockPostCount'] = $statConfig['it_block_posts'] ? $stats['blockPostCount'] : null;
            $stats['blockCommentCount'] = $statConfig['it_block_comments'] ? $stats['blockCommentCount'] : null;

            $stats['likeMeCount'] = $statConfig['user_liker_count'] ? $stats['likeMeCount'] : null;
            $stats['dislikeMeCount'] = $statConfig['user_disliker_count'] ? $stats['dislikeMeCount'] : null;
            $stats['followMeCount'] = $statConfig['user_follower_count'] ? $stats['followMeCount'] : null;
            $stats['blockMeCount'] = $statConfig['user_blocker_count'] ? $stats['blockMeCount'] : null;

            if (! $statConfig['it_posts']) {
                $stats['postPublishCount'] = null;
                $stats['postDigestCount'] = null;
                $stats['postLikeCount'] = null;
                $stats['postDislikeCount'] = null;
                $stats['postFollowCount'] = null;
                $stats['postBlockCount'] = null;
            }

            if (! $statConfig['it_comments']) {
                $stats['commentPublishCount'] = null;
                $stats['commentDigestCount'] = null;
                $stats['commentLikeCount'] = null;
                $stats['commentDislikeCount'] = null;
                $stats['commentFollowCount'] = null;
                $stats['commentBlockCount'] = null;
            }

            $stats['extcredits1'] = ($stats['extcredits1State'] == 3) ? $stats['extcredits1'] : null;
            $stats['extcredits2'] = ($stats['extcredits2State'] == 3) ? $stats['extcredits2'] : null;
            $stats['extcredits3'] = ($stats['extcredits3State'] == 3) ? $stats['extcredits3'] : null;
            $stats['extcredits4'] = ($stats['extcredits4State'] == 3) ? $stats['extcredits4'] : null;
            $stats['extcredits5'] = ($stats['extcredits5State'] == 3) ? $stats['extcredits5'] : null;
        }

        return $stats;
    }

    // handle user data date
    public static function handleUserDate(?array $userData, ?string $timezone = null, ?string $langTag = null)
    {
        if (empty($userData)) {
            return $userData;
        }

        if (empty($timezone)) {
            $userData['verifiedDateTime'] = DateHelper::fresnsFormatConversion($userData['verifiedDateTime'], $langTag);

            $userData['expiryDateTime'] = DateHelper::fresnsFormatConversion($userData['expiryDateTime'], $langTag);

            $userData['lastPublishPost'] = DateHelper::fresnsFormatConversion($userData['lastPublishPost'], $langTag);
            $userData['lastPublishComment'] = DateHelper::fresnsFormatConversion($userData['lastPublishComment'], $langTag);
            $userData['lastEditUsername'] = DateHelper::fresnsFormatConversion($userData['lastEditUsername'], $langTag);
            $userData['lastEditNickname'] = DateHelper::fresnsFormatConversion($userData['lastEditNickname'], $langTag);

            $userData['registerDate'] = DateHelper::fresnsFormatConversion($userData['registerDate'], $langTag);

            $userData['waitDeleteDateTime'] = DateHelper::fresnsFormatConversion($userData['waitDeleteDateTime'], $langTag);

            $userData['roleExpiryDateTime'] = DateHelper::fresnsFormatConversion($userData['roleExpiryDateTime'], $langTag);

            $userData['interaction']['followExpiryDateTime'] = DateHelper::fresnsFormatConversion($userData['interaction']['followExpiryDateTime'], $langTag);

            return $userData;
        }

        $userData['verifiedDateTime'] = DateHelper::fresnsDateTimeByTimezone($userData['verifiedDateTime'], $timezone, $langTag);

        $userData['expiryDateTime'] = DateHelper::fresnsDateTimeByTimezone($userData['expiryDateTime'], $timezone, $langTag);

        $userData['lastPublishPost'] = DateHelper::fresnsDateTimeByTimezone($userData['lastPublishPost'], $timezone, $langTag);
        $userData['lastPublishComment'] = DateHelper::fresnsDateTimeByTimezone($userData['lastPublishComment'], $timezone, $langTag);
        $userData['lastEditUsername'] = DateHelper::fresnsDateTimeByTimezone($userData['lastEditUsername'], $timezone, $langTag);
        $userData['lastEditNickname'] = DateHelper::fresnsDateTimeByTimezone($userData['lastEditNickname'], $timezone, $langTag);

        $userData['registerDate'] = DateHelper::fresnsDateTimeByTimezone($userData['registerDate'], $timezone, $langTag);

        $userData['waitDeleteDateTime'] = DateHelper::fresnsDateTimeByTimezone($userData['waitDeleteDateTime'], $timezone, $langTag);

        $userData['roleExpiryDateTime'] = DateHelper::fresnsDateTimeByTimezone($userData['roleExpiryDateTime'], $timezone, $langTag);

        $userData['interaction']['followExpiryDateTime'] = DateHelper::fresnsDateTimeByTimezone($userData['interaction']['followExpiryDateTime'], $timezone, $langTag);

        return $userData;
    }

    // check content view permission
    public static function checkUserContentViewPerm(string $dateTime, ?int $authUserId = null)
    {
        if (empty($authUserId)) {
            return;
        }

        $modeConfig = ConfigHelper::fresnsConfigByItemKey('site_mode');
        if ($modeConfig == 'public') {
            return;
        }

        $checkUserRolePrivateWhitelist = PermissionUtility::checkUserRolePrivateWhitelist($authUserId);
        if ($checkUserRolePrivateWhitelist) {
            return;
        }

        $authUser = PrimaryHelper::fresnsModelById('user', $authUserId);

        $contentCreatedDatetime = strtotime($dateTime);
        $dateLimit = strtotime($authUser->expired_at);

        if ($contentCreatedDatetime > $dateLimit) {
            throw new ApiException(35304);
        }
    }

    // get content date limit
    public static function getContentDateLimit(?int $authUserId = null)
    {
        if (empty($authUserId)) {
            return null;
        }

        $modeConfig = ConfigHelper::fresnsConfigByItemKey('site_mode');

        if ($modeConfig == 'public') {
            return null;
        }

        $authUser = PrimaryHelper::fresnsModelById('user', $authUserId);

        return $authUser?->expired_at ?? now();
    }

    // check publish perm
    // $type = post / comment
    public function checkPublishPerm(string $type, int $authUserId, ?int $contentMainId = null, ?string $langTag = null, ?string $timezone = null)
    {
        // $contentMainId has a value indicating that it is a modify content, not restricted by the publish check.

        // Check publish limit
        $contentInterval = PermissionUtility::checkContentIntervalTime($authUserId, $type);
        if (! $contentInterval && ! $contentMainId) {
            throw new ApiException(36119);
        }
        $contentCount = PermissionUtility::checkContentPublishCountRules($authUserId, $type);
        if (! $contentCount && ! $contentMainId) {
            throw new ApiException(36120);
        }

        $publishConfig = ConfigUtility::getPublishConfigByType($authUserId, $type, $langTag, $timezone);

        // Check publication requirements
        if (! $publishConfig['perm']['publish']) {
            throw new ApiException(36104, 'Fresns', $publishConfig['perm']['tips']);
        }

        // Check additional requirements
        if ($publishConfig['limit']['status'] && $publishConfig['limit']['isInTime'] && $publishConfig['limit']['rule'] == 2) {
            throw new ApiException(36304);
        }
    }
}
