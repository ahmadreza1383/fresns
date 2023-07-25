<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Words\Detail\DTO;

use Fresns\DTO\DTO;

class GetPostDetailDTO extends DTO
{
    public function rules(): array
    {
        return [
            'pid' => ['string', 'required'],
            'langTag' => ['string', 'nullable'],
            'timezone' => ['string', 'nullable'],
            'authUid' => ['integer', 'nullable'],
            'type' => ['string', 'nullable'],
            'outputPreview' => ['boolean', 'nullable'],
            'mapId' => ['integer', 'nullable', 'between:1,11'],
            'mapLng' => ['numeric', 'nullable', 'min:-180', 'max:180'],
            'mapLat' => ['numeric', 'nullable', 'min:-90', 'max:90'],
        ];
    }
}
