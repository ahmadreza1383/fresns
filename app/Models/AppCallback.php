<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Models;

class AppCallback extends Model
{
    const TYPE_CUSTOMIZE = 1;
    const TYPE_RELOAD = 2;
    const TYPE_TOKEN = 3;
    const TYPE_ACCOUNT = 4;
    const TYPE_USER = 5;
    const TYPE_GROUP = 6;
    const TYPE_HASHTAG = 7;
    const TYPE_POST = 8;
    const TYPE_COMMENT = 9;
    const TYPE_ARCHIVE = 10;
    const TYPE_EXTEND = 11;
    const TYPE_OPERATION = 12;
    const TYPE_FILE = 13;
    const TYPE_MAP = 14;
    const TYPE_CONTENT_READ_AUTH = 15;
    const TYPE_CONTENT_USER_LIST = 16;
    const TYPE_CONTENT_COMMENT_BUTTON = 17;
    const TYPE_CONTENT_COMMENT_CONFIG = 18;

    protected $casts = [
        'content' => 'json',
    ];
}
