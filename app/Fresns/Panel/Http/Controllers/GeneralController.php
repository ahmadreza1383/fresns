<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Panel\Http\Controllers;

use App\Fresns\Panel\Http\Requests\UpdateGeneralRequest;
use App\Helpers\CacheHelper;
use App\Helpers\ConfigHelper;
use App\Helpers\PrimaryHelper;
use App\Models\Config;
use App\Models\File;
use App\Models\FileUsage;
use App\Models\Language;
use App\Models\Plugin;
use App\Models\Role;
use Illuminate\Support\Str;

class GeneralController extends Controller
{
    public function show()
    {
        // config keys
        $configKeys = [
            'utc',
            'site_url',
            'site_name',
            'site_desc',
            'site_intro',
            'site_icon',
            'site_logo',
            'site_copyright',
            'site_copyright_years',
            'site_mode',
            'site_public_status',
            'site_public_service',
            'site_email_register',
            'site_phone_register',
            'site_login_or_register',
            'site_private_status',
            'site_private_service',
            'site_private_end_after',
            'site_private_whitelist_roles',
            'site_email_login',
            'site_phone_login',
            'site_email',
        ];

        // language keys
        $langKeys = [
            'site_name',
            'site_desc',
            'site_intro',
        ];
        $configs = Config::whereIn('item_key', $configKeys)->get();

        $languages = Language::ofConfig()->whereIn('table_key', $langKeys)->get();

        $params = [];
        foreach ($configs as $config) {
            $params[$config->item_key] = $config->item_value;
        }

        $langParams = [];
        $defaultLangParams = [];
        foreach ($langKeys as $langKey) {
            $langParams[$langKey] = $languages->where('table_key', $langKey)->pluck('lang_content', 'lang_tag')->toArray();
            $defaultLangParams[$langKey] = $languages->where('table_key', $langKey)->where('lang_tag', $this->defaultLanguage)->first()['lang_content'] ?? '';
        }

        $plugins = Plugin::all();
        $registerPlugins = $plugins->filter(function ($plugin) {
            return in_array('register', $plugin->scene);
        });
        $joinPlugins = $plugins->filter(function ($plugin) {
            return in_array('join', $plugin->scene);
        });

        $configImageInfo['iconUrl'] = ConfigHelper::fresnsConfigFileUrlByItemKey('site_icon');
        $configImageInfo['iconType'] = ConfigHelper::fresnsConfigFileValueTypeByItemKey('site_icon');
        $configImageInfo['logoUrl'] = ConfigHelper::fresnsConfigFileUrlByItemKey('site_logo');
        $configImageInfo['logoType'] = ConfigHelper::fresnsConfigFileValueTypeByItemKey('site_logo');
        $configImageInfo[] = $configImageInfo;

        $roles = Role::all();

        return view('FsView::systems.general', compact('params', 'configImageInfo', 'langParams', 'defaultLangParams', 'registerPlugins', 'joinPlugins', 'roles'));
    }

    public function update(UpdateGeneralRequest $request)
    {
        if ($request->file('site_icon_file')) {
            $wordBody = [
                'usageType' => FileUsage::TYPE_SYSTEM,
                'platformId' => 4,
                'tableName' => 'configs',
                'tableColumn' => 'item_value',
                'tableKey' => 'site_icon',
                'type' => File::TYPE_IMAGE,
                'file' => $request->file('site_icon_file'),
            ];
            $fresnsResp = \FresnsCmdWord::plugin('Fresns')->uploadFile($wordBody);
            if ($fresnsResp->isErrorResponse()) {
                return back()->with('failure', $fresnsResp->getMessage());
            }
            $fileId = PrimaryHelper::fresnsFileIdByFid($fresnsResp->getData('fid'));
            $request->request->set('site_icon', $fileId);
        } elseif ($request->get('site_icon_url')) {
            $request->request->set('site_icon', $request->get('site_icon_url'));
        }

        if ($request->file('site_logo_file')) {
            $wordBody = [
                'usageType' => FileUsage::TYPE_SYSTEM,
                'platformId' => 4,
                'tableName' => 'configs',
                'tableColumn' => 'item_value',
                'tableKey' => 'site_logo',
                'type' => File::TYPE_IMAGE,
                'file' => $request->file('site_logo_file'),
            ];
            $fresnsResp = \FresnsCmdWord::plugin('Fresns')->uploadFile($wordBody);
            if ($fresnsResp->isErrorResponse()) {
                return back()->with('failure', $fresnsResp->getMessage());
            }
            $fileId = PrimaryHelper::fresnsFileIdByFid($fresnsResp->getData('fid'));
            $request->request->set('site_logo', $fileId);
        } elseif ($request->get('site_logo_url')) {
            $request->request->set('site_logo', $request->get('site_logo_url'));
        }

        $configKeys = [
            'site_url',
            'site_copyright',
            'site_icon',
            'site_logo',
            'site_copyright_years',
            'site_mode',
            'site_public_status',
            'site_public_service',
            'site_email_register',
            'site_phone_register',
            'site_login_or_register',
            'site_private_status',
            'site_private_service',
            'site_private_end_after',
            'site_private_whitelist_roles',
            'site_email_login',
            'site_phone_login',
            'site_email',
        ];

        $configs = Config::whereIn('item_key', $configKeys)->get();
        foreach ($configKeys as $configKey) {
            $config = $configs->where('item_key', $configKey)->first();
            if (! $config) {
                continue;
            }

            if (! $request->has($configKey)) {
                $config->setDefaultValue();
                $config->save();
                continue;
            }

            if ($configKey == 'site_url' && $request->get('site_url')) {
                $url = Str::of($request->get('site_url'))->trim();
                $url = Str::of($url)->rtrim('/');

                $request->$configKey = $url;
            }

            $value = $request->$configKey;
            if ($configKey == 'site_private_whitelist_roles') {
                if (in_array(0, $request->$configKey)) {
                    $value = [];
                }
            }

            $config->item_value = $value;
            $config->save();
        }

        CacheHelper::forgetFresnsConfigs([
            'site_icon',
            'site_logo',
        ]);

        return $this->updateSuccess();
    }
}
