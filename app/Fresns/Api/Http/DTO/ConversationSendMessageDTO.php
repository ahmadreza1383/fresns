<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Api\Http\DTO;

use Fresns\DTO\DTO;

class ConversationSendMessageDTO extends DTO
{
    public function rules(): array
    {
        return [
            'uidOrUsername' => ['required'],
            'message' => ['string', 'nullable', 'required_without:fid'],
            'fid' => ['string', 'nullable', 'required_without:message'],
        ];
    }
}
