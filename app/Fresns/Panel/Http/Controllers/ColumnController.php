<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Panel\Http\Controllers;

use App\Models\Config;
use App\Models\Language;

class ColumnController extends Controller
{
    public function index()
    {
        // config keys
        $configKeys = [
            'menu_like_users',
            'menu_dislike_users',
            'menu_follow_users',
            'menu_block_users',
            'menu_like_groups',
            'menu_dislike_groups',
            'menu_follow_groups',
            'menu_block_groups',
            'menu_like_hashtags',
            'menu_dislike_hashtags',
            'menu_follow_hashtags',
            'menu_block_hashtags',
            'menu_nearby_posts',
            'menu_location_posts',
            'menu_like_posts',
            'menu_dislike_posts',
            'menu_follow_posts',
            'menu_block_posts',
            'menu_nearby_comments',
            'menu_location_comments',
            'menu_like_comments',
            'menu_dislike_comments',
            'menu_follow_comments',
            'menu_block_comments',
            'menu_follow_all_posts',
            'menu_follow_user_posts',
            'menu_follow_group_posts',
            'menu_follow_hashtag_posts',
            'menu_follow_all_comments',
            'menu_follow_user_comments',
            'menu_follow_group_comments',
            'menu_follow_hashtag_comments',
            'menu_account',
            'menu_account_register',
            'menu_account_login',
            'menu_account_reset_password',
            'menu_account_users',
            'menu_account_wallet',
            'menu_account_settings',
            'menu_conversations',
            'menu_notifications',
            'menu_notifications_all',
            'menu_notifications_systems',
            'menu_notifications_recommends',
            'menu_notifications_likes',
            'menu_notifications_dislikes',
            'menu_notifications_follows',
            'menu_notifications_blocks',
            'menu_notifications_mentions',
            'menu_notifications_comments',
            'menu_notifications_quotes',
            'menu_search',
            'menu_editor_functions',
            'menu_editor_drafts',
            'menu_profile_likes',
            'menu_profile_dislikes',
            'menu_profile_followers',
            'menu_profile_blockers',
            'menu_profile_followers_you_follow',
            'menu_profile_like_users',
            'menu_profile_like_groups',
            'menu_profile_like_hashtags',
            'menu_profile_like_posts',
            'menu_profile_like_comments',
            'menu_profile_dislike_users',
            'menu_profile_dislike_groups',
            'menu_profile_dislike_hashtags',
            'menu_profile_dislike_posts',
            'menu_profile_dislike_comments',
            'menu_profile_follow_users',
            'menu_profile_follow_groups',
            'menu_profile_follow_hashtags',
            'menu_profile_follow_posts',
            'menu_profile_follow_comments',
            'menu_profile_block_users',
            'menu_profile_block_groups',
            'menu_profile_block_hashtags',
            'menu_profile_block_posts',
            'menu_profile_block_comments',
        ];

        foreach ($configKeys as $configKey) {
            $config = Config::where('item_key', $configKey)->first();
            if (! $config) {
                $config = new Config();
                $config->item_key = $configKey;
                $config->item_type = 'string';
                $config->is_multilingual = 1;
                $config->save();
            }
        }

        $configs = Config::whereIn('item_key', $configKeys)
            ->with('languages')
            ->get();
        $configs = $configs->mapWithKeys(function ($config) {
            return [$config->item_key => $config];
        });

        $langKeys = $configKeys;

        $defaultLangParams = Language::ofConfig()
            ->whereIn('table_key', $langKeys)
            ->where('lang_tag', $this->defaultLanguage)
            ->pluck('lang_content', 'table_key');

        return view('FsView::clients.columns', compact('configs', 'defaultLangParams'));
    }
}
