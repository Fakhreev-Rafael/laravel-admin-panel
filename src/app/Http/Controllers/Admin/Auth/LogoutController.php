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
        Logger::http()->info('Incoming request', [
            'controller' => __CLASS__,
            'function' => __FUNCTION__,
            'ip' => request()->ip(),
            'method' => request()->method(),
            'uri' => request()->path(),
            'user' => request()->user()?->id,
        ]);

        try {
            
            $logoutHandleAction->execute();

        } catch (\Throwable $th) {
            
            abort(404);
        }

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admin.auth.login.index');
    }
}