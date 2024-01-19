<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Models;

class AccountLoginToken extends Model
{
    use Traits\IsEnabledTrait;

    protected $dates = [
        'expired_at',
    ];
}
