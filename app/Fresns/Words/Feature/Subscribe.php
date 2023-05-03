<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Words\Feature;

use App\Fresns\Words\Feature\DTO\AddSubscribeItemDTO;
use App\Helpers\CacheHelper;
use App\Helpers\StrHelper;
use App\Models\Config;
use App\Utilities\SubscribeUtility;
use Fresns\CmdWordManager\Traits\CmdWordResponseTrait;

class Subscribe
{
    use CmdWordResponseTrait;

    // addSubscribeItem
    public function addSubscribeItem($wordBody)
    {
        $dtoWordBody = new AddSubscribeItemDTO($wordBody);

        $subTableName = null;
        if ($dtoWordBody->type == SubscribeUtility::TYPE_TABLE_DATA_CHANGE && $dtoWordBody->subTableName) {
            $subTableName = StrHelper::qualifyTableName($dtoWordBody->subTableName);
        }

        $subscribeItems = Config::withTrashed()->where('item_key', 'subscribe_items')->first();
        if (empty($subscribeItems)) {
            return $this->failure(21008);
        }

        $itemArr = $subscribeItems->item_value ?? [];

        $found = false;
        foreach ($itemArr as $item) {
            if ($item['type'] == $dtoWordBody->type && $item['fskey'] == $dtoWordBody->fskey && $item['cmdWord'] == $dtoWordBody->cmdWord && $item['subTableName'] == $subTableName) {
                $found = true;
                break;
            }
        }

        if (! $found) {
            $itemArr[] = [
                'type' => $dtoWordBody->type,
                'fskey' => $dtoWordBody->fskey,
                'cmdWord' => $dtoWordBody->cmdWord,
                'subTableName' => $subTableName,
            ];
        }

        $subscribeItems->update([
            'item_value' => $itemArr,
        ]);

        CacheHelper::forgetFresnsConfigs('subscribe_items');

        return $this->success();
    }

    // removeSubscribeItem
    public function removeSubscribeItem($wordBody)
    {
        $dtoWordBody = new AddSubscribeItemDTO($wordBody);

        $subTableName = null;
        if ($dtoWordBody->type == SubscribeUtility::TYPE_TABLE_DATA_CHANGE && $dtoWordBody->subTableName) {
            $subTableName = StrHelper::qualifyTableName($dtoWordBody->subTableName);
        }

        $subscribeItems = Config::withTrashed()->where('item_key', 'subscribe_items')->first();
        if (empty($subscribeItems)) {
            return $this->failure(21008);
        }

        $itemArr = $subscribeItems->item_value ?? [];

        $newItemArr = array_filter($itemArr, function ($item) use ($dtoWordBody, $subTableName) {
            return ! ($item['type'] == $dtoWordBody->type && $item['fskey'] == $dtoWordBody->fskey && $item['cmdWord'] == $dtoWordBody->cmdWord && $item['subTableName'] == $subTableName);
        });

        $newItemArr = array_values($newItemArr);

        $subscribeItems->update([
            'item_value' => $newItemArr,
        ]);

        CacheHelper::forgetFresnsConfigs('subscribe_items');

        return $this->success();
    }
}
