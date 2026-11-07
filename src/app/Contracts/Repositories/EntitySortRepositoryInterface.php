<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Collections\EntitySortCollection;
use App\Models\EntitySort;

interface EntitySortRepositoryInterface
{
    /**
     * Return active sorts by entity.
     * 
     * @param string $entity
     * 
     * @return \App\Collections\EntitySortCollection
     */
    public function getActiveByEntity(string $entity): EntitySortCollection;

    /**
     * Return default by entity.
     * 
     * @param string $entity
     * 
     * @return \App\Models\EntitySort
     */
    public function getDefaultByEntity(string $entity): EntitySort;

    /**
     * Return the unique entity sort.
     * 
     * @param string $entity
     * @param string $field
     * @param string $direction
     * 
     * @return \App\Models\EntitySort|null
     */
    public function getUnique(string $entity, string $field, string $direction): ?EntitySort;

}