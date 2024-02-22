<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

use App\Fresns\Install\Http\Controllers as ApiController;
use App\Fresns\Install\Http\Middleware\ChangeLanguage;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->name('api.')->middleware([
    ChangeLanguage::class,
])->group(function () {
    Route::post('install', [ApiController\InstallController::class, 'install'])->name('install.fresns');
});
