<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Fresns\Panel\Http\Controllers;

use App\Fresns\Panel\Http\Requests\StoreAdminRequest;
use App\Models\Account;
use App\Models\App;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Account::ofAdmin()->get();
        $isFounder = self::isFounder();
        $upgradeCount = App::where('is_upgrade', true)->count();

        return view('FsView::dashboard.admins', compact('admins', 'isFounder', 'upgradeCount'));
    }

    public function store(StoreAdminRequest $request)
    {
        $isFounder = self::isFounder();
        if (! $isFounder) {
            return back()->with('failure', __('FsLang::tips.requestFailure'));
        }

        $accountName = $request->accountName;

        filter_var($accountName, FILTER_VALIDATE_EMAIL) ?
            $credentials['email'] = $accountName :
            $credentials['phone'] = $accountName;

        $admin = Account::where($credentials)->isEnabled()->first();

        if (! $admin) {
            return back()->with('failure', __('FsLang::tips.account_not_found'));
        }

        $admin->type = 1;
        $admin->save();

        return $this->createSuccess();
    }

    public function destroy(Account $admin)
    {
        $isFounder = self::isFounder();
        if (! $isFounder) {
            return back()->with('failure', __('FsLang::tips.requestFailure'));
        }

        $admin->type = 3;
        $admin->save();

        return $this->deleteSuccess();
    }

    public static function isFounder()
    {
        return Auth::user()->id == config('app.founder') || Auth::user()->aid == config('app.founder');
    }
}
