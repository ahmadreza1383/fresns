<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Words\Account;

use App\Fresns\Words\Account\DTO\WalletCheckPasswordDTO;
use App\Fresns\Words\Account\DTO\WalletDecreaseDTO;
use App\Fresns\Words\Account\DTO\WalletFreezeDTO;
use App\Fresns\Words\Account\DTO\WalletIncreaseDTO;
use App\Fresns\Words\Account\DTO\WalletRechargeDTO;
use App\Fresns\Words\Account\DTO\WalletRevokeDTO;
use App\Fresns\Words\Account\DTO\WalletUnfreezeDTO;
use App\Fresns\Words\Account\DTO\WalletWithdrawDTO;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\Helpers\PrimaryHelper;
use App\Models\AccountWallet;
use App\Models\AccountWalletLog;
use App\Utilities\ConfigUtility;
use Fresns\CmdWordManager\Traits\CmdWordResponseTrait;
use Illuminate\Support\Facades\Hash;

class Wallet
{
    use CmdWordResponseTrait;

    // cmd word: wallet check password
    public function walletCheckPassword($wordBody)
    {
        $dtoWordBody = new WalletCheckPasswordDTO($wordBody);
        $langTag = AppHelper::getLangTag();

        $accountId = PrimaryHelper::fresnsAccountIdByAid($dtoWordBody->aid);

        $wallet = AccountWallet::where('account_id', $accountId)->isEnabled()->first();
        // Account wallet not exist or has been banned
        if (empty($wallet)) {
            return $this->failure(
                34501,
                ConfigUtility::getCodeMessage(34501, 'Fresns', $langTag)
            );
        }

        if (empty($wallet->password) && empty($dtoWordBody->password)) {
            return $this->success();
        }

        if ($wallet->password) {
            $checkWallet = static::checkWalletPassword($wallet, $dtoWordBody->password);
            // Account wallet password is incorrect
            if (! $checkWallet) {
                return $this->failure(
                    34502,
                    ConfigUtility::getCodeMessage(34502, 'Fresns', $langTag)
                );
            }
        }

        return $this->success();
    }

    // cmd word: wallet recharge
    public function walletRecharge($wordBody)
    {
        $dtoWordBody = new WalletRechargeDTO($wordBody);
        $langTag = AppHelper::getLangTag();

        $accountId = PrimaryHelper::fresnsAccountIdByAid($dtoWordBody->aid);
        $userId = PrimaryHelper::fresnsUserIdByUidOrUsername($dtoWordBody->uid);

        // Account wallet password is incorrect
        if (empty($accountId)) {
            return $this->failure(
                31502,
                ConfigUtility::getCodeMessage(31502, 'Fresns', $langTag)
            );
        }

        $wallet = AccountWallet::where('account_id', $accountId)->isEnabled()->first();
        // Account wallet not exist or has been banned
        if (empty($wallet)) {
            return $this->failure(
                34501,
                ConfigUtility::getCodeMessage(34501, 'Fresns', $langTag)
            );
        }

        $checkClosingBalance = static::checkClosingBalance($wallet);
        // The closing balance not match with the wallet limit
        if (! $checkClosingBalance) {
            return $this->failure(
                34506,
                ConfigUtility::getCodeMessage(34506, 'Fresns', $langTag)
            );
        }

        // amount
        $amountTotal = round($dtoWordBody->amountTotal, 2);
        $systemFee = round($dtoWordBody->systemFee, 2);
        $transactionAmount = $amountTotal - $systemFee;

        $closingBalance = $wallet->balance + $transactionAmount;

        // wallet log
        $logData = [
            'account_id' => $accountId,
            'user_id' => $userId,
            'type' => AccountWalletLog::TYPE_IN_RECHARGE,
            'plugin_fskey' => $dtoWordBody->transactionFskey,
            'transaction_id' => $dtoWordBody->transactionId,
            'transaction_code' => $dtoWordBody->transactionCode,
            'amount_total' => $amountTotal,
            'transaction_amount' => $transactionAmount,
            'system_fee' => $systemFee,
            'opening_balance' => $wallet->balance,
            'closing_balance' => $closingBalance,
            'remark' => $dtoWordBody->remark,
            'more_json' => $dtoWordBody->moreJson,
        ];

        AccountWalletLog::create($logData);

        static::balanceChange($wallet, 'increment', $transactionAmount);

        CacheHelper::forgetFresnsAccount($dtoWordBody->aid);

        return $this->success();
    }

    // cmd word: wallet withdraw
    public function walletWithdraw($wordBody)
    {
        $dtoWordBody = new WalletWithdrawDTO($wordBody);
        $langTag = AppHelper::getLangTag();

        $accountId = PrimaryHelper::fresnsAccountIdByAid($dtoWordBody->aid);
        $userId = PrimaryHelper::fresnsUserIdByUidOrUsername($dtoWordBody->uid);

        // Account wallet password is incorrect
        if (empty($accountId)) {
            return $this->failure(
                31502,
                ConfigUtility::getCodeMessage(31502, 'Fresns', $langTag)
            );
        }

        $wallet = AccountWallet::where('account_id', $accountId)->isEnabled()->first();
        // Account wallet not exist or has been banned
        if (empty($wallet)) {
            return $this->failure(
                34501,
                ConfigUtility::getCodeMessage(34501, 'Fresns', $langTag)
            );
        }

        if ($wallet->password) {
            $checkWallet = static::checkWalletPassword($wallet, $dtoWordBody->password);
            // Account wallet password is incorrect
            if (! $checkWallet) {
                return $this->failure(
                    34502,
                    ConfigUtility::getCodeMessage(34502, 'Fresns', $langTag)
                );
            }
        }

        $checkClosingBalance = static::checkClosingBalance($wallet);
        // The closing balance not match with the wallet limit
        if (! $checkClosingBalance) {
            return $this->failure(
                34506,
                ConfigUtility::getCodeMessage(34506, 'Fresns', $langTag)
            );
        }

        // amount
        $amountTotal = round($dtoWordBody->amountTotal, 2);
        $systemFee = round($dtoWordBody->systemFee, 2);
        $transactionAmount = $amountTotal - $systemFee;

        $closingBalance = $wallet->balance - $transactionAmount;

        $checkBalance = static::checkBalance($wallet, $amountTotal);
        // The counterparty wallet balance is not allowed to make payment
        if (! $checkBalance) {
            return $this->failure(
                34504,
                ConfigUtility::getCodeMessage(34504, 'Fresns', $langTag)
            );
        }

        // wallet log
        $logData = [
            'account_id' => $accountId,
            'user_id' => $userId,
            'type' => AccountWalletLog::TYPE_DE_WITHDRAW,
            'plugin_fskey' => $dtoWordBody->transactionFskey,
            'transaction_id' => $dtoWordBody->transactionId,
            'transaction_code' => $dtoWordBody->transactionCode,
            'amount_total' => $amountTotal,
            'transaction_amount' => $transactionAmount,
            'system_fee' => $systemFee,
            'opening_balance' => $wallet->balance,
            'closing_balance' => $closingBalance,
            'remark' => $dtoWordBody->remark,
            'more_json' => $dtoWordBody->moreJson,
        ];

        AccountWalletLog::create($logData);
        static::balanceChange($wallet, 'decrement', $amountTotal);

        CacheHelper::forgetFresnsAccount($dtoWordBody->aid);

        return $this->success();
    }

    // cmd word: wallet freeze
    public function walletFreeze($wordBody)
    {
        $dtoWordBody = new WalletFreezeDTO($wordBody);
        $langTag = AppHelper::getLangTag();

        $accountId = PrimaryHelper::fresnsAccountIdByAid($dtoWordBody->aid);
        $userId = PrimaryHelper::fresnsUserIdByUidOrUsername($dtoWordBody->uid);

        // Account wallet password is incorrect
        if (empty($accountId)) {
            return $this->failure(
                31502,
                ConfigUtility::getCodeMessage(31502, 'Fresns', $langTag)
            );
        }

        $wallet = AccountWallet::where('account_id', $accountId)->isEnabled()->first();
        // Account wallet not exist or has been banned
        if (empty($wallet)) {
            return $this->failure(
                34501,
                ConfigUtility::getCodeMessage(34501, 'Fresns', $langTag)
            );
        }

        $checkClosingBalance = static::checkClosingBalance($wallet);
        // The closing balance not match with the wallet limit
        if (! $checkClosingBalance) {
            return $this->failure(
                34506,
                ConfigUtility::getCodeMessage(34506, 'Fresns', $langTag)
            );
        }

        // amount
        $amountTotal = round($dtoWordBody->amountTotal, 2);

        $checkBalance = static::checkBalance($wallet, $amountTotal);
        // The counterparty wallet balance is not allowed to make payment
        if (! $checkBalance) {
            return $this->failure(
                34505,
                ConfigUtility::getCodeMessage(34505, 'Fresns', $langTag)
            );
        }

        // wallet log
        $logData = [
            'account_id' => $accountId,
            'user_id' => $userId,
            'type' => AccountWalletLog::TYPE_IN_FREEZE,
            'plugin_fskey' => $dtoWordBody->transactionFskey,
            'transaction_id' => $dtoWordBody->transactionId,
            'transaction_code' => $dtoWordBody->transactionCode,
            'amount_total' => $amountTotal,
            'transaction_amount' => $amountTotal,
            'system_fee' => 0.00,
            'opening_balance' => $wallet->balance,
            'closing_balance' => $wallet->balance,
            'remark' => $dtoWordBody->remark,
            'more_json' => $dtoWordBody->moreJson,
        ];

        AccountWalletLog::create($logData);

        $wallet->increment('freeze_amount', $amountTotal);

        CacheHelper::forgetFresnsAccount($dtoWordBody->aid);

        return $this->success();
    }

    // cmd word: wallet unfreeze
    public function walletUnfreeze($wordBody)
    {
        $dtoWordBody = new WalletUnfreezeDTO($wordBody);
        $langTag = AppHelper::getLangTag();

        $accountId = PrimaryHelper::fresnsAccountIdByAid($dtoWordBody->aid);
        $userId = PrimaryHelper::fresnsUserIdByUidOrUsername($dtoWordBody->uid);

        // Account wallet password is incorrect
        if (empty($accountId)) {
            return $this->failure(
                31502,
                ConfigUtility::getCodeMessage(31502, 'Fresns', $langTag)
            );
        }

        $wallet = AccountWallet::where('account_id', $accountId)->isEnabled()->first();
        // Account wallet not exist or has been banned
        if (empty($wallet)) {
            return $this->failure(
                34501,
                ConfigUtility::getCodeMessage(34501, 'Fresns', $langTag)
            );
        }

        $checkClosingBalance = static::checkClosingBalance($wallet);
        // The closing balance not match with the wallet limit
        if (! $checkClosingBalance) {
            return $this->failure(
                34506,
                ConfigUtility::getCodeMessage(34506, 'Fresns', $langTag)
            );
        }

        // amount
        $amountTotal = round($dtoWordBody->amountTotal, 2);

        // The counterparty wallet balance is not allowed to make payment
        if ($wallet->freeze_amount < $amountTotal) {
            return $this->failure(
                34505,
                ConfigUtility::getCodeMessage(34505, 'Fresns', $langTag)
            );
        }

        // wallet log
        $logData = [
            'account_id' => $accountId,
            'user_id' => $userId,
            'type' => AccountWalletLog::TYPE_DE_UNFREEZE,
            'plugin_fskey' => $dtoWordBody->transactionFskey,
            'transaction_id' => $dtoWordBody->transactionId,
            'transaction_code' => $dtoWordBody->transactionCode,
            'amount_total' => $amountTotal,
            'transaction_amount' => $amountTotal,
            'system_fee' => 0.00,
            'opening_balance' => $wallet->balance,
            'closing_balance' => $wallet->balance,
            'remark' => $dtoWordBody->remark,
            'more_json' => $dtoWordBody->moreJson,
        ];

        AccountWalletLog::create($logData);

        $wallet->decrement('freeze_amount', $amountTotal);

        CacheHelper::forgetFresnsAccount($dtoWordBody->aid);

        return $this->success();
    }

    // cmd word: wallet increase
    public function walletIncrease($wordBody)
    {
        $dtoWordBody = new WalletIncreaseDTO($wordBody);
        $langTag = AppHelper::getLangTag();

        $accountId = PrimaryHelper::fresnsAccountIdByAid($dtoWordBody->aid);
        $userId = PrimaryHelper::fresnsUserIdByUidOrUsername($dtoWordBody->uid);
        $originAccountId = PrimaryHelper::fresnsAccountIdByAid($dtoWordBody->originAid);
        $originUserId = PrimaryHelper::fresnsUserIdByUidOrUsername($dtoWordBody->originUid);

        // Account wallet password is incorrect
        if (empty($accountId)) {
            return $this->failure(
                31502,
                ConfigUtility::getCodeMessage(31502, 'Fresns', $langTag)
            );
        }

        $wallet = AccountWallet::where('account_id', $accountId)->isEnabled()->first();
        // Account wallet not exist or has been banned
        if (empty($wallet)) {
            return $this->failure(
                34501,
                ConfigUtility::getCodeMessage(34501, 'Fresns', $langTag)
            );
        }

        $checkClosingBalance = static::checkClosingBalance($wallet);
        // The closing balance not match with the wallet limit
        if (! $checkClosingBalance) {
            return $this->failure(
                34506,
                ConfigUtility::getCodeMessage(34506, 'Fresns', $langTag)
            );
        }

        // amount
        $amountTotal = round($dtoWordBody->amountTotal, 2);
        $systemFee = round($dtoWordBody->systemFee, 2);
        $transactionAmount = $amountTotal - $systemFee;

        $closingBalance = $wallet->balance + $transactionAmount;

        // wallet log
        $logData = [
            'account_id' => $accountId,
            'user_id' => $userId,
            'type' => AccountWalletLog::TYPE_IN_TRANSACTION,
            'plugin_fskey' => $dtoWordBody->transactionFskey,
            'transaction_id' => $dtoWordBody->transactionId,
            'transaction_code' => $dtoWordBody->transactionCode,
            'amount_total' => $amountTotal,
            'transaction_amount' => $transactionAmount,
            'system_fee' => $systemFee,
            'opening_balance' => $wallet->balance,
            'closing_balance' => $closingBalance,
            'object_account_id' => $originAccountId,
            'object_user_id' => $originUserId,
            'remark' => $dtoWordBody->remark,
            'more_json' => $dtoWordBody->moreJson,
        ];

        // Increase
        if (empty($originAccountId)) {
            AccountWalletLog::create($logData);
            static::balanceChange($wallet, 'increment', $transactionAmount);
        } else {
            $originWallet = AccountWallet::where('account_id', $originAccountId)->isEnabled()->first();

            // The counterparty wallet not exist or has been banned
            if (empty($originWallet)) {
                return $this->failure(
                    34503,
                    ConfigUtility::getCodeMessage(34503, 'Fresns', $langTag)
                );
            }

            $checkBalance = static::checkBalance($originWallet, $amountTotal);
            // The counterparty wallet balance is not allowed to make payment
            if (! $checkBalance) {
                return $this->failure(
                    34505,
                    ConfigUtility::getCodeMessage(34505, 'Fresns', $langTag)
                );
            }

            // The closing balance of the counterparty does not match with the wallet limit
            $checkOriginClosingBalance = static::checkClosingBalance($originWallet);
            if (! $checkOriginClosingBalance) {
                return $this->failure(
                    34507,
                    ConfigUtility::getCodeMessage(34507, 'Fresns', $langTag)
                );
            }

            // increase
            $increaseLog = AccountWalletLog::create($logData);
            static::balanceChange($wallet, 'increment', $transactionAmount);

            $originClosingBalance = $originWallet->balance - $amountTotal;

            // origin wallet log
            $originLogData = [
                'account_id' => $originAccountId,
                'user_id' => $originUserId,
                'type' => AccountWalletLog::TYPE_DE_TRANSACTION,
                'plugin_fskey' => $dtoWordBody->transactionFskey,
                'transaction_id' => $dtoWordBody->transactionId,
                'transaction_code' => $dtoWordBody->transactionCode,
                'amount_total' => $amountTotal,
                'transaction_amount' => $transactionAmount,
                'system_fee' => $systemFee,
                'opening_balance' => $originWallet->balance,
                'closing_balance' => $originClosingBalance,
                'object_account_id' => $accountId,
                'object_user_id' => $userId,
                'object_wallet_log_id' => $increaseLog->id,
                'remark' => $dtoWordBody->remark,
                'more_json' => $dtoWordBody->moreJson,
            ];

            // decrement
            AccountWalletLog::create($originLogData);
            static::balanceChange($originWallet, 'decrement', $amountTotal);
        }

        CacheHelper::forgetFresnsAccount($dtoWordBody->aid);
        CacheHelper::forgetFresnsAccount($dtoWordBody->originAid);

        return $this->success();
    }

    // cmd word: wallet decrease
    public function walletDecrease($wordBody)
    {
        $dtoWordBody = new WalletDecreaseDTO($wordBody);
        $langTag = AppHelper::getLangTag();

        $accountId = PrimaryHelper::fresnsAccountIdByAid($dtoWordBody->aid);
        $userId = PrimaryHelper::fresnsUserIdByUidOrUsername($dtoWordBody->uid);
        $originAccountId = PrimaryHelper::fresnsAccountIdByAid($dtoWordBody->originAid);
        $originUserId = PrimaryHelper::fresnsUserIdByUidOrUsername($dtoWordBody->originUid);

        // Account wallet password is incorrect
        if (empty($accountId)) {
            return $this->failure(
                31502,
                ConfigUtility::getCodeMessage(31502, 'Fresns', $langTag)
            );
        }

        $wallet = AccountWallet::where('account_id', $accountId)->isEnabled()->first();
        // Account wallet not exist or has been banned
        if (empty($wallet)) {
            return $this->failure(
                34501,
                ConfigUtility::getCodeMessage(34501, 'Fresns', $langTag)
            );
        }

        if ($wallet->password) {
            $checkWallet = static::checkWalletPassword($wallet, $dtoWordBody->password);
            // Account wallet password is incorrect
            if (! $checkWallet) {
                return $this->failure(
                    34502,
                    ConfigUtility::getCodeMessage(34502, 'Fresns', $langTag)
                );
            }
        }

        // amount
        $amountTotal = round($dtoWordBody->amountTotal, 2);
        $systemFee = round($dtoWordBody->systemFee, 2);
        $transactionAmount = $amountTotal - $systemFee;

        $closingBalance = $wallet->balance - $transactionAmount;

        $checkBalance = static::checkBalance($wallet, $amountTotal);
        // The counterparty wallet balance is not allowed to make payment
        if (! $checkBalance) {
            return $this->failure(
                34504,
                ConfigUtility::getCodeMessage(34504, 'Fresns', $langTag)
            );
        }

        $checkClosingBalance = static::checkClosingBalance($wallet);
        // The closing balance not match with the wallet limit
        if (! $checkClosingBalance) {
            return $this->failure(
                34506,
                ConfigUtility::getCodeMessage(34506, 'Fresns', $langTag)
            );
        }

        // wallet log
        $logData = [
            'account_id' => $accountId,
            'user_id' => $userId,
            'type' => AccountWalletLog::TYPE_DE_TRANSACTION,
            'plugin_fskey' => $dtoWordBody->transactionFskey,
            'transaction_id' => $dtoWordBody->transactionId,
            'transaction_code' => $dtoWordBody->transactionCode,
            'amount_total' => $amountTotal,
            'transaction_amount' => $transactionAmount,
            'system_fee' => $systemFee,
            'opening_balance' => $wallet->balance,
            'closing_balance' => $closingBalance,
            'object_account_id' => $originAccountId,
            'object_user_id' => $originUserId,
            'remark' => $dtoWordBody->remark,
            'more_json' => $dtoWordBody->moreJson,
        ];

        // decrement
        if (empty($originAccountId)) {
            AccountWalletLog::create($logData);
            static::balanceChange($wallet, 'decrement', $amountTotal);
        } else {
            $originWallet = AccountWallet::where('account_id', $originAccountId)->isEnabled()->first();

            // The counterparty wallet not exist or has been banned
            if (empty($originWallet)) {
                return $this->failure(
                    34503,
                    ConfigUtility::getCodeMessage(34503, 'Fresns', $langTag)
                );
            }

            // The closing balance of the counterparty does not match with the wallet limit
            $checkOriginClosingBalance = static::checkClosingBalance($originWallet);
            if (! $checkOriginClosingBalance) {
                return $this->failure(
                    34507,
                    ConfigUtility::getCodeMessage(34507, 'Fresns', $langTag)
                );
            }

            // decrement
            $decrementLog = AccountWalletLog::create($logData);
            static::balanceChange($wallet, 'decrement', $amountTotal);

            $originClosingBalance = $originWallet->balance + $transactionAmount;

            // origin wallet log
            $originLogData = [
                'account_id' => $originAccountId,
                'user_id' => $originUserId,
                'type' => AccountWalletLog::TYPE_IN_TRANSACTION,
                'plugin_fskey' => $dtoWordBody->transactionFskey,
                'transaction_id' => $dtoWordBody->transactionId,
                'transaction_code' => $dtoWordBody->transactionCode,
                'amount_total' => $amountTotal,
                'transaction_amount' => $transactionAmount,
                'system_fee' => $systemFee,
                'opening_balance' => $originWallet->balance,
                'closing_balance' => $originClosingBalance,
                'object_account_id' => $accountId,
                'object_user_id' => $userId,
                'object_wallet_log_id' => $decrementLog->id,
                'remark' => $dtoWordBody->remark,
                'more_json' => $dtoWordBody->moreJson,
            ];

            // increment
            AccountWalletLog::create($originLogData);
            static::balanceChange($originWallet, 'increment', $transactionAmount);
        }

        CacheHelper::forgetFresnsAccount($dtoWordBody->aid);
        CacheHelper::forgetFresnsAccount($dtoWordBody->originAid);

        return $this->success();
    }

    // cmd word: wallet revoke
    public function walletRevoke($wordBody)
    {
        $dtoWordBody = new WalletRevokeDTO($wordBody);
        $langTag = AppHelper::getLangTag();

        if (empty($dtoWordBody->logId) && empty($dtoWordBody->transactionId) && empty($dtoWordBody->transactionCode)) {
            return $this->failure(
                21005,
                ConfigUtility::getCodeMessage(21005, 'Fresns', $langTag)
            );
        }

        $accountId = PrimaryHelper::fresnsAccountIdByAid($dtoWordBody->aid);
        $userId = PrimaryHelper::fresnsUserIdByUidOrUsername($dtoWordBody->uid);

        // Account wallet password is incorrect
        if (empty($accountId)) {
            return $this->failure(
                31502,
                ConfigUtility::getCodeMessage(31502, 'Fresns', $langTag)
            );
        }

        $walletLogQuery = AccountWalletLog::where('account_id', $accountId);

        $walletLogQuery->when($userId, function ($query, $value) {
            $query->where('user_id', $value);
        });

        $walletLogQuery->when($dtoWordBody->logId, function ($query, $value) {
            $query->where('id', $value);
        });

        $walletLogQuery->when($dtoWordBody->transactionId, function ($query, $value) {
            $query->where('transaction_id', $value);
        });

        $walletLogQuery->when($dtoWordBody->transactionCode, function ($query, $value) {
            $query->where('transaction_code', $value);
        });

        $walletLog = $walletLogQuery->where('state', AccountWalletLog::STATE_SUCCESS)->first();

        if (empty($walletLog)) {
            return $this->failure(
                32201,
                ConfigUtility::getCodeMessage(32201, 'Fresns', $langTag)
            );
        }

        $wallet = AccountWallet::where('account_id', $accountId)->first();
        if (empty($wallet)) {
            return $this->failure(
                34501,
                ConfigUtility::getCodeMessage(34501, 'Fresns', $langTag)
            );
        }

        // object wallet and log
        $objectWalletLog = null;
        $objectWallet = null;
        if ($walletLog->object_wallet_log_id) {
            $objectWalletLog = AccountWalletLog::where('id', $walletLog->object_wallet_log_id)->first();

            $objectWallet = AccountWallet::where('account_id', $objectWalletLog?->account_id)->first();

            if ($objectWalletLog && $objectWallet) {
                $checkObjectBalance = static::checkBalance($objectWallet, $objectWalletLog->amount_total);
                // The counterparty wallet balance is not allowed to make payment
                if (! $checkObjectBalance) {
                    return $this->failure(
                        34504,
                        ConfigUtility::getCodeMessage(34504, 'Fresns', $langTag)
                    );
                }

                $objectWalletLog->update([
                    'is_enabled' => false,
                ]);
            }
        }

        // The counterparty wallet balance is not allowed to make payment
        $checkBalance = static::checkBalance($wallet, $walletLog->amount_total);
        if (! $checkBalance) {
            return $this->failure(
                34504,
                ConfigUtility::getCodeMessage(34504, 'Fresns', $langTag)
            );
        }

        $walletLog->update([
            'is_enabled' => false,
        ]);

        switch ($walletLog->type) {
            case AccountWalletLog::TYPE_IN_TRANSACTION:
                $wallet->decrement('balance', $walletLog->amount_total);

                if ($objectWalletLog && $objectWallet) {
                    $objectWallet->increment('balance', $objectWalletLog->amount_total);
                }
                break;

            case AccountWalletLog::TYPE_DE_TRANSACTION:
                $wallet->increment('balance', $walletLog->amount_total);

                if ($objectWalletLog && $objectWallet) {
                    $objectWallet->decrement('balance', $objectWalletLog->amount_total);
                }
                break;
        }

        CacheHelper::forgetFresnsAccount($dtoWordBody->aid);

        return $this->success();
    }

    // check wallet password
    public static function checkWalletPassword(AccountWallet $wallet, ?string $walletPassword = null): bool
    {
        if ($wallet->password && empty($walletPassword)) {
            return false;
        }

        return Hash::check($walletPassword, $wallet->password);
    }

    // check balance
    public static function checkBalance(AccountWallet $wallet, float $amount): bool
    {
        $balance = $wallet->balance - $wallet->freeze_amount;

        if ($balance < $amount) {
            return false;
        }

        return true;
    }

    // check closing balance
    public static function checkClosingBalance(AccountWallet $wallet): bool
    {
        $walletLog = AccountWalletLog::where('account_id', $wallet->account_id)->where('state', AccountWalletLog::STATE_SUCCESS)->latest('id')->first();

        $closingBalance = $walletLog?->closing_balance ?? 0.00;

        return $wallet->balance == $closingBalance;
    }

    // wallet balance
    public static function balanceChange(AccountWallet $wallet, string $actionType, float $transactionAmount)
    {
        if (! in_array($actionType, ['increment', 'decrement'])) {
            return;
        }

        $wallet->$actionType('balance', $transactionAmount);
    }

    // wallet freeze amount
    public static function freezeAmountChange(AccountWallet $wallet, string $actionType, float $transactionAmount)
    {
        if (! in_array($actionType, ['increment', 'decrement'])) {
            return;
        }

        $wallet->$actionType('freeze_amount', $transactionAmount);
    }
}
