<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Api\Http\DTO;

use Fresns\DTO\DTO;

class GlobalRolesDTO extends DTO
{
    public function rules(): array
    {
        return [
            'rids' => ['string', 'nullable'],
            'status' => ['boolean', 'nullable'],
            'pageSize' => ['integer', 'nullable', 'between:1,50'],
            'page' => ['integer', 'nullable'],
        ];
    }
}
