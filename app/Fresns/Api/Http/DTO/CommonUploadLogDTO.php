<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Api\Http\DTO;

use Fresns\DTO\DTO;

class CommonUploadLogDTO extends DTO
{
    public function rules(): array
    {
        return [
            'type' => ['integer', 'required', 'between:1,16'],
            'fskey' => ['string', 'nullable', 'exists:App\Models\Plugin,fskey'],
            'objectName' => ['string', 'required'],
            'objectAction' => ['string', 'required'],
            'objectResult' => ['integer', 'required', 'in:1,2,3'],
            'objectOrderId' => ['integer', 'nullable'],
            'deviceToken' => ['string', 'nullable'],
            'moreInfo' => ['array', 'nullable'],
        ];
    }
}
