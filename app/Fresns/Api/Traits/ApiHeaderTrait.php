<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Api\Traits;

use App\Helpers\ConfigHelper;
use App\Helpers\DateHelper;
use App\Helpers\PrimaryHelper;
use App\Models\Account;
use App\Models\User;

trait ApiHeaderTrait
{
    // platformId
    public function platformId(): int
    {
        return \request()->header('X-Fresns-Client-Platform-Id');
    }

    // version
    public function version(): string
    {
        return \request()->header('X-Fresns-Client-Version');
    }

    // appId
    public function appId(): string
    {
        return \request()->header('X-Fresns-App-Id');
    }

    // langTag
    public function langTag(): string
    {
        $clientLangTag = \request()->header('X-Fresns-Client-Lang-Tag');
        $defaultLanguage = ConfigHelper::fresnsConfigDefaultLangTag();

        if (empty($clientLangTag)) {
            return $defaultLanguage;
        }

        $langTagArr = ConfigHelper::fresnsConfigLangTags();
        foreach ($langTagArr as $langTag) {
            if ($langTag == $clientLangTag) {
                return $langTag;
            }
        }

        return $defaultLanguage;
    }

    // timezone
    public function timezone(): ?string
    {
        $clientTimezone = \request()->header('X-Fresns-Client-Timezone');

        if (empty($clientTimezone)) {
            return null;
        }

        $databaseTimezone = DateHelper::fresnsDatabaseTimezone();

        if ($clientTimezone == $databaseTimezone) {
            return null;
        }

        return $clientTimezone;
    }

    // deviceInfo
    public function deviceInfo(): array
    {
        return json_decode(\request()->header('X-Fresns-Client-Device-Info'), true) ?? [];
    }

    // auth account
    public function account(): ?Account
    {
        $aid = \request()->header('X-Fresns-Aid');

        if (empty($aid)) {
            return null;
        }

        return PrimaryHelper::fresnsModelByFsid('account', $aid);
    }

    // auth user
    public function user(): ?User
    {
        $uid = \request()->header('X-Fresns-Uid');

        if (empty($uid)) {
            return null;
        }

        return PrimaryHelper::fresnsModelByFsid('user', $uid);
    }
}
