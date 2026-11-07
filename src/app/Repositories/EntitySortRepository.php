<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Collections\EntitySortCollection;
use App\Contracts\Repositories\EntitySortRepositoryInterface;
use App\Models\EntitySort;
use Illuminate\Database\Eloquent\Collection;
use Override;

final class EntitySortRepository implements EntitySortRepositoryInterface
{
    /**
     * @inheritdoc
     */
    #[Override]
    public function getActiveByEntity(string $entity): EntitySortCollection
    {
        return EntitySort::query()
            ->where('entity', $entity)
            ->where('is_active', true)
            ->orderBy('field')
            ->orderBy('direction')
            ->get();
    }

    /**
     * @inheritdoc
     */
    #[Override]
    public function getDefaultByEntity(string $entity): EntitySort
    {
        return EntitySort::query()
            ->where('entity', $entity)
            ->where('is_default', true)
            ->first();        
    }

    /**
     * @inheritdoc
     */
    #[Override]
    public function getUnique(string $entity, string $field, string $direction): ?EntitySort
    {
        return EntitySort::query()
            ->where('entity', $entity)
            ->where('field', $field)
            ->where('direction', $direction)
            ->where('is_active', true)
            ->first(); 
    }

}