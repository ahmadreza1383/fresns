<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Words\Send\DTO;

use Fresns\DTO\DTO;

class SendWechatMessageDTO extends DTO
{
    public function rules(): array
    {
        return [
            'uid' => ['integer', 'required', 'exists:App\Models\User,uid'],
            'channel' => ['integer', 'required', 'in:1,2'],
            'template' => ['string', 'nullable'],
            'coverUrl' => ['url', 'nullable'],
            'title' => ['string', 'nullable'],
            'content' => ['string', 'nullable'],
            'time' => ['string', 'nullable', 'date_format:"Y-m-d H:i:s"'],
            'linkType' => ['integer', 'nullable', 'in:1,2,3,4,5'],
            'linkFsid' => ['required_with:linkType'],
            'linkUrl' => ['url', 'nullable'],
        ];
    }
}
