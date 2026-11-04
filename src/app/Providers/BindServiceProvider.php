<?php

namespace App\Providers;

use App\Actions\Admin\LoginHandleAction;
use App\Actions\Admin\LogoutHandleAction;
use App\Actions\Admin\PermissionIndexAction;
use App\Contracts\Actions\Admin\LoginHandleActionInterface;
use App\Contracts\Actions\Admin\LogoutHandleActionInterface;
use App\Contracts\Actions\Admin\PermissionIndexActionInterface;
use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Contracts\Repositories\PermissionRepositoryInterface;
use App\Contracts\Services\ActionAccessServiceInterface;
use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Services\EntityRegistryInterface;
use App\Contracts\Services\FieldAccessServiceInterface;
use App\Contracts\Services\PermissionSyncServiceInterface;
use App\Contracts\Services\RecordAccessServiceInterface;
use App\Contracts\Services\RecordQueryServiceInterface;
use App\Contracts\Services\SortServiceInterface;
use App\Repositories\EmployeeRepository;
use App\Repositories\PermissionRepository;
use App\Services\ActionAccessService;
use App\Services\AuthService;
use App\Services\EntityRegistry;
use App\Services\FieldAccessService;
use App\Services\PermissionSyncService;
use App\Services\RecordAccessService;
use App\Services\RecordQueryService;
use App\Services\SortService;
use Illuminate\Support\ServiceProvider;

class BindServiceProvider extends ServiceProvider
{
    /**
     * @var array $bindings
     */
    public array $bindings = [
        ActionAccessServiceInterface::class => ActionAccessService::class,
        AuthServiceInterface::class => AuthService::class,
        EntityRegistryInterface::class => EntityRegistry::class,
        FieldAccessServiceInterface::class => FieldAccessService::class,
        PermissionSyncServiceInterface::class => PermissionSyncService::class,
        RecordAccessServiceInterface::class => RecordAccessService::class,
        RecordQueryServiceInterface::class => RecordQueryService::class,
        SortServiceInterface::class => SortService::class,

        EmployeeRepositoryInterface::class => EmployeeRepository::class,
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
