<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Console\Commands;

use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\Models\Plugin;
use App\Utilities\AppUtility;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ManualUpgradeFresns extends Command
{
    protected $signature = 'fresns:manual-upgrade';

    protected $description = 'manual upgrade fresns';

    const STEP_FAILURE = 0;
    const STEP_START = 1;
    const STEP_UPDATE_DATA = 2;
    const STEP_COMPOSER_UPDATE_EXTENSIONS = 3;
    const STEP_PUBLISH_AND_ACTIVATE_EXTENSIONS = 4;
    const STEP_UPDATE_VERSION = 5;
    const STEP_CLEAR = 6;
    const STEP_DONE = 7;

    public function __construct()
    {
        parent::__construct();
    }

    // execute the console command
    public function handle()
    {
        Cache::forget('manualUpgradeTip');
        $this->updateStep(self::STEP_START);

        // Check if an upgrade is needed
        $checkVersion = AppUtility::checkVersion();
        if (! $checkVersion) {
            $checkVersionTip = 'No new version, Already the latest version of Fresns.';

            $this->info($checkVersionTip);
            $this->info('Step --: Upgrade end');

            Cache::put('manualUpgradeStep', self::STEP_DONE);
            Cache::put('manualUpgradeTip', $checkVersionTip);

            return Command::SUCCESS;
        }

        try {
            if (! $this->updateData()) {
                $extractFileTip = 'Failed to execute the version command';

                $this->error($extractFileTip);

                Cache::put('manualUpgradeStep', self::STEP_FAILURE);
                Cache::put('manualUpgradeTip', $extractFileTip);

                return Command::FAILURE;
            }

            if (! $this->pluginComposerInstall()) {
                $this->updateStep(self::STEP_FAILURE);

                return Command::FAILURE;
            }

            $this->pluginPublishAndActivate();
            $this->upgradeFinish();
        } catch (\Exception $e) {
            logger($e->getMessage());

            $this->error($e->getMessage());
            $this->updateStep(self::STEP_FAILURE);

            return Command::FAILURE;
        }

        $this->clear();
        $this->updateStep(self::STEP_DONE);

        return Command::SUCCESS;
    }

    // output update step info
    public function updateStep(int $step)
    {
        $stepInfo = match ($step) {
            self::STEP_FAILURE => 'Step --: Upgrade failure',
            self::STEP_START => 'Step 1/7: Initialization verification',
            self::STEP_UPDATE_DATA => 'Step 2/7: Update fresns data',
            self::STEP_COMPOSER_UPDATE_EXTENSIONS => 'Step 3/7: Composer update all plugin dependency packages',
            self::STEP_PUBLISH_AND_ACTIVATE_EXTENSIONS => 'Step 4/7: Publish and activate plugins',
            self::STEP_UPDATE_VERSION => 'Step 5/7: Update fresns version',
            self::STEP_CLEAR => 'Step 6/7: Clear cache',
            self::STEP_DONE => 'Step 7/7: Done',
            default => 'Step --: Upgrade end',
        };

        // upgrade step
        return $this->updateOutput($stepInfo, $step);
    }

    public function updateOutput($content, $step)
    {
        if ($step == self::STEP_FAILURE) {
            $this->error($content);
        } else {
            $this->info($content);
        }

        $output = Cache::get('manualUpgradeTip')."\n";
        $output .= $content;

        Cache::put('manualUpgradeStep', $step);
        Cache::put('manualUpgradeTip', $output);
    }

    // step 2: Update fresns data
    public function updateData()
    {
        $this->updateStep(self::STEP_UPDATE_DATA);

        logger('-- command: migrate');

        $exitCode = $this->call('migrate', ['--force' => true]);
        if ($exitCode) {
            logger('-- -- migrate info: exitCode = '.$exitCode);

            return false;
        }

        return true;
    }

    // step 3: composer all plugins
    public function pluginComposerInstall()
    {
        $this->updateStep(self::STEP_COMPOSER_UPDATE_EXTENSIONS);

        try {
            $exitCode = $this->call('plugin:composer-update');

            if ($exitCode) {
                logger('-- -- composer info: plugin composer-update exitCode = '.$exitCode);

                return false;
            }
        } catch (\Exception $e) {
            logger('-- -- composer info: plugin composer exception >> '.$e->getMessage());

            $this->error($e->getMessage());

            return false;
        }

        return true;
    }

    // step 4: publish and activate plugins
    public function pluginPublishAndActivate()
    {
        $this->updateStep(self::STEP_PUBLISH_AND_ACTIVATE_EXTENSIONS);

        $plugins = Plugin::all();

        foreach ($plugins as $plugin) {
            try {
                $this->call('plugin:publish', ['fskey' => $plugin->fskey]);

                if ($plugin->is_enabled) {
                    $this->call('plugin:activate', ['fskey' => $plugin->fskey]);
                }
            } catch (\Exception $e) {
                logger('-- publish and activate: exception >> '.$e->getMessage());

                $this->error($e->getMessage());
            }
        }

        return true;
    }

    // step 5: edit fresns version info
    public function upgradeFinish(): bool
    {
        $this->updateStep(self::STEP_UPDATE_VERSION);

        $newVersion = AppHelper::VERSION;

        AppUtility::editVersion($newVersion);

        return true;
    }

    // step 6: clear cache
    public function clear()
    {
        $this->updateStep(self::STEP_CLEAR);

        CacheHelper::clearConfigCache('fresnsSystem');
        CacheHelper::clearConfigCache('fresnsConfig');
        CacheHelper::clearConfigCache('fresnsView');
        CacheHelper::clearConfigCache('fresnsRoute');
        CacheHelper::clearConfigCache('fresnsEvent');
        CacheHelper::clearConfigCache('fresnsSchedule');
        CacheHelper::clearConfigCache('frameworkConfig');

        return true;
    }
}
