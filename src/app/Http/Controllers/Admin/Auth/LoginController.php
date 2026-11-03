<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Auth;

use App\Contracts\Actions\Admin\LoginHandleActionInterface;
use App\DataTransferObjects\Admin\LoginHandleData;
use App\Enums\LogChannels;
use App\Exceptions\EmployeeNotFoundException;
use App\Exceptions\InvalidPasswordException;
use App\Helpers\Logger;
use App\Http\Controllers\Admin\CoreController;
use App\Http\Requests\Admin\Auth\LoginHandleRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LoginController extends CoreController
{
    /**
     * Display login form. 
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(): Factory|View
    {
        return view('admin.auth.login.index');
    }

    /**
     * Handle the login form.
     * 
     * @param \App\Http\Requests\Admin\Auth\LoginHandleRequest $request
     * @param \App\Contracts\Actions\Admin\LoginHandleActionInterface $loginHandleAction
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(LoginHandleRequest $request, LoginHandleActionInterface $loginHandleAction): RedirectResponse
    {
        Logger::http()->info('Incoming request', [
            'controller' => __CLASS__,
            'function' => __FUNCTION__,
            'ip' => $request->ip(),
            'method' => $request->method(),
            'uri' => $request->path(),
            'data' => $request->all(),
        ]);  

        try {
            
            $data = LoginHandleData::fromRequest($request);

            $loginHandleAction->execute($data);

            $request->session()->regenerate();

        } catch (EmployeeNotFoundException|InvalidPasswordException $e) {

            Logger::errors()->error('Error of authentication', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('notification', [
                'heading' => trans('notifications.headings.error'),
                'text' => trans('notifications.text.login'),
                'type' => 'error',
            ]);

            return back();

        }

        return redirect()->route('admin.permission.index');
    }
}