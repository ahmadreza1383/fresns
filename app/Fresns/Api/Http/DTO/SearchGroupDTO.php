<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Api\Http\DTO;

use Fresns\DTO\DTO;

class SearchGroupDTO extends DTO
{
    public function rules(): array
    {
        return [
            'searchKey' => ['string', 'required'],
            'recommend' => ['boolean', 'nullable'],
            'createdDays' => ['integer', 'nullable'],
            'createdDate' => ['string', 'nullable', 'in:today,yesterday,week,lastWeek,month,lastMonth,year,lastYear'],
            'createdDateGt' => ['date_format:Y-m-d', 'nullable', 'before:createdDateLt'], // groups->created_at
            'createdDateLt' => ['date_format:Y-m-d', 'nullable', 'after:createdDateGt'],
            'viewCountGt' => ['integer', 'nullable', 'lt:viewCountLt'], // groups->view_count
            'viewCountLt' => ['integer', 'nullable', 'gt:viewCountGt'],
            'likeCountGt' => ['integer', 'nullable', 'lt:likeCountLt'], // groups->like_count
            'likeCountLt' => ['integer', 'nullable', 'gt:likeCountGt'],
            'dislikeCountGt' => ['integer', 'nullable', 'lt:dislikeCountLt'], // groups->dislike_count
            'dislikeCountLt' => ['integer', 'nullable', 'gt:dislikeCountGt'],
            'followCountGt' => ['integer', 'nullable', 'lt:followCountLt'], // groups->follow_count
            'followCountLt' => ['integer', 'nullable', 'gt:followCountGt'],
            'blockCountGt' => ['integer', 'nullable', 'lt:blockCountLt'], // groups->block_count
            'blockCountLt' => ['integer', 'nullable', 'gt:blockCountGt'],
            'postCountGt' => ['integer', 'nullable', 'lt:postCountLt'], // groups->post_count
            'postCountLt' => ['integer', 'nullable', 'gt:postCountGt'],
            'postDigestCountGt' => ['integer', 'nullable', 'lt:postDigestCountLt'], // groups->post_digest_count
            'postDigestCountLt' => ['integer', 'nullable', 'gt:postDigestCountGt'],
            'orderType' => ['string', 'nullable', 'in:createdTime,random,view,like,follow,block,post,postDigest,rating'],
            'orderDirection' => ['string', 'nullable', 'in:asc,desc'],
            'whitelistKeys' => ['string', 'nullable'],
            'blacklistKeys' => ['string', 'nullable'],
            'pageSize' => ['integer', 'nullable', 'between:1,30'],
            'page' => ['integer', 'nullable'],
        ];
    }
}
