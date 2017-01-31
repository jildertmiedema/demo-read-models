<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use App\BusinessLogic\Sales\Account;

final class AccountController extends Controller
{
    public function show($id)
    {
        $account = Account::findOrFail($id);

        return view('accounts.show', compact('account'));
    }
}
