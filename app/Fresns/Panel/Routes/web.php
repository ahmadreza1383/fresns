<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

use App\Fresns\Panel\Http\Controllers\AdminController;
use App\Fresns\Panel\Http\Controllers\AppController;
use App\Fresns\Panel\Http\Controllers\BlockWordController;
use App\Fresns\Panel\Http\Controllers\CodeMessageController;
use App\Fresns\Panel\Http\Controllers\ColumnController;
use App\Fresns\Panel\Http\Controllers\ConfigController;
use App\Fresns\Panel\Http\Controllers\DashboardController;
use App\Fresns\Panel\Http\Controllers\ExtendChannel;
use App\Fresns\Panel\Http\Controllers\ExtendContentHandlerController;
use App\Fresns\Panel\Http\Controllers\ExtendContentTypeController;
use App\Fresns\Panel\Http\Controllers\ExtendEditorController;
use App\Fresns\Panel\Http\Controllers\ExtendGroupController;
use App\Fresns\Panel\Http\Controllers\ExtendManageController;
use App\Fresns\Panel\Http\Controllers\ExtendUserFeatureController;
use App\Fresns\Panel\Http\Controllers\ExtendUserProfileController;
use App\Fresns\Panel\Http\Controllers\GeneralController;
use App\Fresns\Panel\Http\Controllers\GroupController;
use App\Fresns\Panel\Http\Controllers\IframeController;
use App\Fresns\Panel\Http\Controllers\InteractionController;
use App\Fresns\Panel\Http\Controllers\LanguageController;
use App\Fresns\Panel\Http\Controllers\LanguageMenuController;
use App\Fresns\Panel\Http\Controllers\LanguagePackController;
use App\Fresns\Panel\Http\Controllers\LoginController;
use App\Fresns\Panel\Http\Controllers\MenuController;
use App\Fresns\Panel\Http\Controllers\PluginController;
use App\Fresns\Panel\Http\Controllers\PluginUsageController;
use App\Fresns\Panel\Http\Controllers\PolicyController;
use App\Fresns\Panel\Http\Controllers\PublishController;
use App\Fresns\Panel\Http\Controllers\RenameController;
use App\Fresns\Panel\Http\Controllers\RoleController;
use App\Fresns\Panel\Http\Controllers\SendController;
use App\Fresns\Panel\Http\Controllers\SessionKeyController;
use App\Fresns\Panel\Http\Controllers\SettingController;
use App\Fresns\Panel\Http\Controllers\StickerController;
use App\Fresns\Panel\Http\Controllers\StickerGroupController;
use App\Fresns\Panel\Http\Controllers\StorageController;
use App\Fresns\Panel\Http\Controllers\UpgradeController;
use App\Fresns\Panel\Http\Controllers\UserController;
use App\Fresns\Panel\Http\Controllers\UserSearchController;
use App\Fresns\Panel\Http\Controllers\WalletController;
use App\Helpers\CacheHelper;
use App\Models\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

try {
    $cacheKey = 'fresns_panel_login_path';
    $cacheTag = 'fresnsSystems';
    $loginPath = CacheHelper::get($cacheKey, $cacheTag);

    if (empty($loginPath)) {
        $loginConfig = Config::where('item_key', 'panel_path')->first();

        $loginPath = $loginConfig->item_value ?? 'admin';

        CacheHelper::put($loginPath, $cacheKey, $cacheTag, 10, now()->addMinutes(10));
    }
} catch (\Exception $e) {
    $loginPath = 'admin';
}

Route::get($loginPath, [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post($loginPath, [LoginController::class, 'login'])->name('login');

Route::middleware(['panelAuth'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // update config
    Route::put('configs/{config:item_key}', [ConfigController::class, 'update'])->name('configs.update');
    // plugin usages
    Route::put('plugin-usages/{id}/rating', [PluginUsageController::class, 'updateRating'])->name('plugin-usages.rating.update');
    Route::resource('plugin-usages', PluginUsageController::class)->only([
        'store', 'update', 'destroy',
    ])->parameters([
        'plugin-usages' => 'pluginUsage',
    ]);
    // update language
    Route::put('batch/languages/{itemKey}', [LanguageController::class, 'batchUpdate'])->name('languages.batch.update');
    Route::put('languages/{itemKey}', [LanguageController::class, 'update'])->name('languages.update');
    // users search
    Route::get('users/search', [UserSearchController::class, 'search'])->name('users.search');

    // The following pages function

    // dashboard-home
    Route::get('dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('dashboard-data', [DashboardController::class, 'dashboardData'])->name('dashboard.data');
    Route::get('composer/diagnose', [DashboardController::class, 'composerDiagnose'])->name('composer.diagnose');
    Route::get('composer/config', [DashboardController::class, 'composerConfigInfo'])->name('composer.config');
    // dashboard-events
    Route::get('events', [DashboardController::class, 'eventList'])->name('events.index');
    // dashboard-caches
    Route::get('caches', [SettingController::class, 'caches'])->name('caches.index');
    Route::any('cache/all/clear', [SettingController::class, 'cacheAllClear'])->name('cache.all.clear');
    Route::post('cache/select/clear', [SettingController::class, 'cacheSelectClear'])->name('cache.select.clear');
    // dashboard-upgrades
    Route::get('upgrades', [UpgradeController::class, 'show'])->name('upgrades');
    Route::patch('upgrade/check', [UpgradeController::class, 'checkFresnsVersion'])->name('upgrade.check');
    // fresns upgrade
    Route::post('auto-upgrade', [UpgradeController::class, 'autoUpgrade'])->name('upgrade.auto');
    Route::post('manual-upgrade', [UpgradeController::class, 'manualUpgrade'])->name('upgrade.manual');
    Route::get('upgrade/info', [UpgradeController::class, 'upgradeInfo'])->name('upgrade.info');

    // dashboard-admins
    Route::resource('admins', AdminController::class)->only([
        'index', 'store', 'destroy',
    ]);
    // dashboard-settings
    Route::get('settings', [SettingController::class, 'show'])->name('settings');
    Route::put('settings/update', [SettingController::class, 'update'])->name('settings.update');

    // systems
    Route::prefix('systems')->group(function () {
        // languages
        Route::get('languages', [LanguageMenuController::class, 'index'])->name('languages.index');
        Route::post('languageMenus', [LanguageMenuController::class, 'store'])->name('languageMenus.store');
        Route::put('languageMenus/status/switch', [LanguageMenuController::class, 'switchStatus'])->name('languageMenus.status.switch');
        Route::put('languageMenus/{langTag}', [LanguageMenuController::class, 'update'])->name('languageMenus.update');
        Route::put('languageMenus/{langTag}/rating', [LanguageMenuController::class, 'updateRating'])->name('languageMenus.rating.update');
        Route::put('default/languages/update', [LanguageMenuController::class, 'updateDefaultLanguage'])->name('languageMenus.default.update');
        Route::delete('languageMenus/{langTag}', [LanguageMenuController::class, 'destroy'])->name('languageMenus.destroy');
        // general
        Route::get('general', [GeneralController::class, 'show'])->name('general.index');
        Route::put('general', [GeneralController::class, 'update'])->name('general.update');
        // policy
        Route::get('policy', [PolicyController::class, 'show'])->name('policy.index');
        Route::put('policy', [PolicyController::class, 'update'])->name('policy.update');
        // send
        Route::get('send', [SendController::class, 'show'])->name('send.index');
        Route::put('send/update', [SendController::class, 'update'])->name('send.update');
        Route::put('send/verifyCodeTemplate/{itemKey}/sms', [SendController::class, 'updateSms'])->name('send.sms.update');
        Route::put('send/verifyCodeTemplate/{itemKey}/email', [SendController::class, 'updateEmail'])->name('send.email.update');
        // user
        Route::get('user', [UserController::class, 'show'])->name('user.index');
        Route::put('user-update', [UserController::class, 'update'])->name('user.update');
        Route::put('user/update-extcredits', [UserController::class, 'updateExtcredits'])->name('user.update.extcredits');
        // wallet
        Route::get('wallet', [WalletController::class, 'show'])->name('wallet.index');
        Route::put('wallet', [WalletController::class, 'update'])->name('wallet.update');
        Route::get('wallet/recharge', [WalletController::class, 'rechargeIndex'])->name('wallet.recharge.index');
        Route::post('wallet/recharge', [WalletController::class, 'rechargeStore'])->name('wallet.recharge.store');
        Route::put('wallet/recharge/{pluginUsage}', [WalletController::class, 'rechargeUpdate'])->name('wallet.recharge.update');
        Route::get('wallet/withdraw', [WalletController::class, 'withdrawIndex'])->name('wallet.withdraw.index');
        Route::post('wallet/withdraw', [WalletController::class, 'withdrawStore'])->name('wallet.withdraw.store');
        Route::put('wallet/withdraw/{pluginUsage}', [WalletController::class, 'withdrawUpdate'])->name('wallet.withdraw.update');
        // storage-image
        Route::get('storage/image', [StorageController::class, 'imageShow'])->name('storage.image.index');
        Route::put('storage/image', [StorageController::class, 'imageUpdate'])->name('storage.image.update');
        // storage-video
        Route::get('storage/video', [StorageController::class, 'videoShow'])->name('storage.video.index');
        Route::put('storage/video', [StorageController::class, 'videoUpdate'])->name('storage.video.update');
        // storage-audio
        Route::get('storage/audio', [StorageController::class, 'audioShow'])->name('storage.audio.index');
        Route::put('storage/audio', [StorageController::class, 'audioUpdate'])->name('storage.audio.update');
        // storage-document
        Route::get('storage/document', [StorageController::class, 'documentShow'])->name('storage.document.index');
        Route::put('storage/document', [StorageController::class, 'documentUpdate'])->name('storage.document.update');
        // storage-substitution
        Route::get('storage/substitution', [StorageController::class, 'substitutionShow'])->name('storage.substitution.index');
        Route::put('storage/substitution', [StorageController::class, 'substitutionUpdate'])->name('storage.substitution.update');
    });

    // operatings
    Route::prefix('operations')->group(function () {
        // rename
        Route::get('rename', [RenameController::class, 'show'])->name('rename.index');
        // interaction
        Route::get('interaction', [InteractionController::class, 'show'])->name('interaction.index');
        Route::put('interaction', [InteractionController::class, 'update'])->name('interaction.update');
        Route::put('interaction-update-hashtag-regexp', [InteractionController::class, 'updateHashtagRegexp'])->name('interaction.update.hashtag.regexp');
        // stickers
        Route::resource('stickers', StickerGroupController::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
        Route::put('stickers/{sticker}/rating', [StickerGroupController::class, 'updateRating'])->name('stickers.rating');
        Route::put('sticker-images/batch', [StickerController::class, 'batchUpdate'])->name('sticker-images.batch.update');
        Route::resource('sticker-images', StickerController::class)->only([
            'index', 'store', 'update', 'destroy',
        ])->parameters([
            'sticker-images' => 'stickerImage',
        ]);
        // publish-post
        Route::get('publish/post', [PublishController::class, 'postShow'])->name('publish.post.index');
        Route::put('publish/post', [PublishController::class, 'postUpdate'])->name('publish.post.update');
        // publish-comment
        Route::get('publish/comment', [PublishController::class, 'commentShow'])->name('publish.comment.index');
        Route::put('publish/comment', [PublishController::class, 'commentUpdate'])->name('publish.comment.update');
        // block-words
        Route::resource('block-words', BlockWordController::class)->only([
            'index', 'store', 'update', 'destroy',
        ])->parameters([
            'block-words' => 'blockWord',
        ]);
        Route::post('block-words/export', [BlockWordController::class, 'export'])->name('block-words.export');
        Route::post('block-words/import', [BlockWordController::class, 'import'])->name('block-words.import');
        // roles
        Route::resource('roles', RoleController::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
        Route::put('roles/{role}/rating', [RoleController::class, 'updateRating'])->name('roles.rating');
        Route::get('roles/{role}/permissions', [RoleController::class, 'showPermissions'])->name('roles.permissions.index');
        Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');
        // groups
        Route::resource('groups', GroupController::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
        Route::get('groups/recommend', [GroupController::class, 'recommendIndex'])->name('groups.recommend.index');
        Route::get('groups/inactive', [GroupController::class, 'disableIndex'])->name('groups.inactive.index');
        Route::put('groups/{group}/merge', [GroupController::class, 'mergeGroup'])->name('groups.merge');
        Route::put('groups/{group}/rating', [GroupController::class, 'updateRating'])->name('groups.rating.update');
        Route::put('groups/{group}/recommend_rating', [GroupController::class, 'updateRecommendRank'])->name('groups.recommend.rating.update');
        Route::put('groups/{group}/enable', [GroupController::class, 'updateEnable'])->name('groups.enable.update');
        Route::get('groups/categories', [GroupController::class, 'groupIndex'])->name('groups.categories.index');
    });

    // extends
    Route::prefix('extends')->group(function () {
        // editor
        Route::resource('editor', ExtendEditorController::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
        // content-type
        Route::resource('content-type', ExtendContentTypeController::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
        Route::put('content-type/{id}/dataSources/{key}', [ExtendContentTypeController::class, 'updateSource'])->name('content-type.source');
        // content-handler
        Route::get('content-handler', [ExtendContentHandlerController::class, 'index'])->name('content-handler.index');
        Route::put('content-handler', [ExtendContentHandlerController::class, 'update'])->name('content-handler.update');
        // manage
        Route::resource('manage', ExtendManageController::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
        // group
        Route::resource('group', ExtendGroupController::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
        // user-feature
        Route::resource('user-feature', ExtendUserFeatureController::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
        // user-profile
        Route::resource('user-profile', ExtendUserProfileController::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
        // channel
        Route::resource('channel', ExtendChannel::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
    });

    // clients
    Route::prefix('clients')->group(function () {
        // menus
        Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
        Route::put('menus/{key}/update', [MenuController::class, 'update'])->name('menus.update');
        // columns
        Route::get('columns', [ColumnController::class, 'index'])->name('columns.index');
        // language pack
        Route::get('language-packs', [LanguagePackController::class, 'index'])->name('language.packs.index');
        Route::get('language-packs/{langTag}/edit', [LanguagePackController::class, 'edit'])->name('language.packs.edit');
        Route::put('language-packs/{langTag}', [LanguagePackController::class, 'update'])->name('language.packs.update');
        // code messages
        Route::get('code-messages', [CodeMessageController::class, 'index'])->name('code.messages.index');
        Route::put('code-messages/{codeMessage}', [CodeMessageController::class, 'update'])->name('code.messages.update');
        // path
        Route::get('paths', [AppController::class, 'pathIndex'])->name('paths.index');
        Route::put('paths', [AppController::class, 'pathUpdate'])->name('paths.update');
        // basic
        Route::get('basic', [AppController::class, 'basicIndex'])->name('client.basic');
        Route::put('basic', [AppController::class, 'basicUpdate'])->name('client.basic.update');
        // status
        Route::get('status', [AppController::class, 'statusIndex'])->name('client.status');
        Route::put('status', [AppController::class, 'statusUpdate'])->name('client.status.update');
    });

    // app center
    Route::prefix('app-center')->group(function () {
        // plugins
        Route::get('plugins', [PluginController::class, 'index'])->name('plugins.index');
        // apps
        Route::get('apps', [PluginController::class, 'appIndex'])->name('apps.index');
        // session key
        Route::resource('keys', SessionKeyController::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
        Route::put('keys/{key}/reset', [SessionKeyController::class, 'reset'])->name('keys.reset');
    });

    // iframe
    Route::get('setting', [IframeController::class, 'setting'])->name('iframe.setting');
    Route::get('marketplace', [IframeController::class, 'marketplace'])->name('iframe.marketplace');

    // plugin manage
    Route::prefix('plugin')->name('plugin.')->group(function () {
        // dashboard upgrade page
        Route::patch('update-code', [PluginController::class, 'updateCode'])->name('update.code');
        // plugin install and upgrade
        Route::put('install', [PluginController::class, 'install'])->name('install');
        Route::put('upgrade', [PluginController::class, 'upgrade'])->name('upgrade');
        // activate or deactivate
        Route::patch('update', [PluginController::class, 'update'])->name('update');
        // uninstall
        Route::delete('uninstall', [PluginController::class, 'uninstall'])->name('uninstall');
        // check status
        Route::post('check-status', [PluginController::class, 'checkStatus'])->name('check.status');
    });

    // apps
    Route::prefix('app')->name('app.')->group(function () {
        Route::post('download', [PluginController::class, 'appDownload'])->name('download');
        Route::delete('delete', [PluginController::class, 'appDelete'])->name('delete');
    });
});

// FsLang
Route::get('js/{locale?}/translations', function ($locale) {
    $panelLangCacheKey = "fresns_panel_translation_{$locale}";
    $panelLangCacheTag = 'fresnsSystems';
    $langStrings = CacheHelper::get($panelLangCacheKey, $panelLangCacheTag);

    if (empty($langStrings)) {
        $langPath = app_path('Fresns/Panel/Resources/lang/'.$locale);

        if (! is_dir($langPath)) {
            $langPath = app_path('Fresns/Panel/Resources/lang/'.config('app.locale'));
        }

        $langStrings = collect(File::allFiles($langPath))->flatMap(function ($file) {
            $name = basename($file, '.php');
            $strings[$name] = require $file;

            return $strings;
        })->toJson();

        CacheHelper::put($langStrings, $panelLangCacheKey, $panelLangCacheTag);
    }

    // get request, return translation content
    return \response()->json([
        'data' => json_decode($langStrings, true),
    ]);
})->name('translations');

// empty page
Route::any('{any}', [LoginController::class, 'emptyPage'])->name('empty')->where('any', '.*');
