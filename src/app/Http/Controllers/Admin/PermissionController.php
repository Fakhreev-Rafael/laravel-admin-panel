<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Contracts\Actions\Admin\PermissionIndexActionInterface;
use App\Enums\Permissions;
use App\Helpers\Logger;
use App\Http\Requests\Admin\PermissionIndexRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        Gate::authorize(Permissions::PermissionsView->value);

        $viewModel = $permissionIndexAction->execute($request->validated('sort'));

        return view('admin.permission.index', compact('viewModel'));
    }
}