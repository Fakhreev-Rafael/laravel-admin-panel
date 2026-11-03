<?php

namespace App\Repositories;

use App\Collections\EntityFieldCollection;
use App\Contracts\Repositories\EntityFieldRepositoryInterface;
use App\Helpers\Logger;
use App\Models\EntityField;

class EntityFieldRepository implements EntityFieldRepositoryInterface
{
    /**
     * Get allowed entity fields by roles.
     *
     * @param string $entity
     * @param array $roleIds
     * 
     * @return \App\Collections\EntityFieldCollection
     */
    public function getAllowedFields(string $entity, array $roleIds): EntityFieldCollection {
        $fields = EntityField::query()
            ->where('entity', $entity)
            ->where('active', true)
            ->whereHas('roles', function ($query) use ($roleIds) {
                $query->whereIn('roles.id', $roleIds);
            })
            ->get();

        Logger::database()->debug('Querying allowed entity fields', [
            'employee' => request()->user()?->id,
            'entity' => $entity,
            'role_ids' => $roleIds,
            'count' => $fields->count(),
        ]);

        return $fields;
    }
}