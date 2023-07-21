<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Api\Http\DTO;

use Fresns\DTO\DTO;

class AccountLoginDTO extends DTO
{
    public function rules(): array
    {
        return [
            'type' => ['string', 'required', 'in:email,phone'],
            'account' => ['required'], // email or integer
            'countryCode' => ['integer', 'nullable', 'required_if:type,phone'],
            'password' => ['string', 'nullable', 'required_without:verifyCode'],
            'verifyCode' => ['string', 'nullable', 'required_without:password'],
            'deviceToken' => ['string', 'nullable'],
        ];
    }
}
