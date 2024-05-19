<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Console;

use App\Helpers\ConfigHelper;
use App\Models\App;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $crontabItems = ConfigHelper::fresnsConfigByItemKey('crontab_items') ?? [];

        foreach ($crontabItems as $cron) {
            if ($cron['fskey'] != 'Fresns') {
                $plugin = App::where('fskey', $cron['fskey'])->isEnabled()->first();

                if (empty($plugin)) {
                    continue;
                }
            }

            $schedule->call(function () use ($cron) {
                info("schedule: {$cron['fskey']} -> {$cron['cmdWord']} | {$cron['cronTableFormat']}");

                \FresnsCmdWord::plugin($cron['fskey'])->{$cron['cmdWord']}();
            })->cron($cron['cronTableFormat']);
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        // require base_path('routes/console.php');
    }

    public function has($command)
    {
        return $this->getArtisan()->has($command);
    }
}
