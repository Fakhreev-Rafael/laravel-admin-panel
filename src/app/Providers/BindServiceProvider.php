<?php

namespace App\Providers;

use App\Actions\Admin\LoginHandleAction;
use App\Actions\Admin\LogoutHandleAction;
use App\Actions\Admin\PermissionIndexAction;
use App\Contracts\Actions\Admin\LoginHandleActionInterface;
use App\Contracts\Actions\Admin\LogoutHandleActionInterface;
use App\Contracts\Actions\Admin\PermissionIndexActionInterface;
use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Contracts\Repositories\EntitySortRepositoryInterface;
use App\Contracts\Repositories\PermissionRepositoryInterface;
use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Services\PermissionServiceInterface;
use App\Contracts\Services\SortServiceInterface;
use App\Repositories\EmployeeRepository;
use App\Repositories\EntitySortRepository;
use App\Repositories\PermissionRepository;
use App\Services\AuthService;
use App\Services\PermissionService;
use App\Services\SortService;
use Illuminate\Support\ServiceProvider;

class BindServiceProvider extends ServiceProvider
{
    /**
     * @var array $bindings
     */
    public array $bindings = [
        AuthServiceInterface::class => AuthService::class,
        PermissionServiceInterface::class => PermissionService::class,

        EmployeeRepositoryInterface::class => EmployeeRepository::class,
        EntitySortRepositoryInterface::class => EntitySortRepository::class,
        PermissionRepositoryInterface::class => PermissionRepository::class,

    ];

    /**
     * @var array $singletons
     */
    public array $singletons = [
        LoginHandleActionInterface::class => LoginHandleAction::class,
        LogoutHandleActionInterface::class => LogoutHandleAction::class,
        PermissionIndexActionInterface::class => PermissionIndexAction::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
