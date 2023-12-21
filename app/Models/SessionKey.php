<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Models;

use Illuminate\Support\Collection;

class SessionKey extends Model
{
    const TYPE_CORE = 1;
    const TYPE_MANAGE = 2;
    const TYPE_APP = 3;

    use Traits\IsEnabledTrait;

    public function platformName($platforms = []): string
    {
        if (! $platforms instanceof Collection) {
            $platforms = collect($platforms);
        }

        $platform = $platforms->where('id', $this->platform_id)->first();
        if (! $platform) {
            return '';
        }

        return $platform['name'] ?? '';
    }

    public function app()
    {
        return $this->belongsTo(App::class, 'app_fskey', 'fskey');
    }
}
