<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Panel\Http\Requests;

class UpdateLanguageMenuRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'order' => 'required|int',
            'old_lang_tag' => 'string',
            'continent_id' => 'int',
            'area_code' => 'string',
            'area_status' => 'required|boolean',
            'length_unit' => 'required|string',
            'date_format' => 'required|string',
            'time_format_minute' => 'required|string',
            'time_format_hour' => 'required|string',
            'time_format_day' => 'required|string',
            'time_format_month' => 'required|string',
            'time_format_year' => 'required|string',
            'is_enabled' => 'required|boolean',
        ];

        if ($this->method() == 'POST') {
            $rules['lang_code'] = 'required|string';
        } elseif ($this->method() == 'PUT') {
            $rules['lang_code'] = 'string';
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
        ];
    }
}
