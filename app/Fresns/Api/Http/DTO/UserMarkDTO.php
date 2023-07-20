<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Api\Http\DTO;

use Fresns\DTO\DTO;

class UserMarkDTO extends DTO
{
    public function rules(): array
    {
        return [
            'interactionType' => ['string', 'required', 'in:like,dislike,follow,block'],
            'markType' => ['string', 'required', 'in:user,group,hashtag,post,comment'],
            'fsid' => ['required'],
        ];
    }
}
