<?php

declare(strict_types=1);

namespace App\Contracts\Services;

interface PermissionSyncServiceInterface
{
    /**
     * Sync permissions.
     * 
     * @return void
     */
    public function sync(): void;

    /**
     * Return slugs.
     * 
     * @return array
     */
    public function getObsoleteSlugs(): array;
}
