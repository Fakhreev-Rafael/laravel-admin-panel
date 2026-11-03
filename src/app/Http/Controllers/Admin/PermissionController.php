<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Contracts\Actions\Admin\PermissionIndexActionInterface;
use App\Helpers\Logger;
use App\Http\Requests\Admin\PermissionIndexRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PermissionController extends CoreController
{
    /**
     * Display a permission collection.
     * 
     * @param \App\Contracts\Actions\Admin\PermissionIndexActionInterface $permissionIndexAction
     * @param \App\Http\Requests\Admin\PermissionIndexRequest $request
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(PermissionIndexRequest $request, PermissionIndexActionInterface $permissionIndexAction): Factory|View
    {
        $sort = $request->input('sort');

        Logger::http()->info('Incoming request', [
            'controller' => __CLASS__,
            'function' => __FUNCTION__,
            'ip' => request()->ip(),
            'method' => request()->method(),
            'uri' => request()->path(),
            'employee' => request()->user(),
            
        ]);

        $viewModel = $permissionIndexAction->execute($sort);

        return view('admin.permission.index', compact('viewModel'));
    }
}