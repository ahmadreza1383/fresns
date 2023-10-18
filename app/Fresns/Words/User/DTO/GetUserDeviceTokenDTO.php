<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Words\User\DTO;

use Fresns\DTO\DTO;

class GetUserDeviceTokenDTO extends DTO
{
    public function rules(): array
    {
        return [
            'uid' => ['integer', 'required', 'exists:App\Models\User,uid'],
            'platformId' => ['integer', 'nullable', 'between:1,11'],
        ];
    }
}
