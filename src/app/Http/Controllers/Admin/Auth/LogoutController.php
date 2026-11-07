<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Auth;

use App\Contracts\Actions\Admin\LogoutHandleActionInterface;
use App\Helpers\Logger;
use App\Http\Controllers\Admin\CoreController;

class LogoutController extends CoreController
{
    /**
     * Handle the logout.
     * 
     * @param \App\Contracts\Actions\Admin\LogoutHandleActionInterface $logoutHandleAction
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(LogoutHandleActionInterface $logoutHandleAction)
    {
        $logoutHandleAction->execute();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admin.auth.login.index');
    }
}