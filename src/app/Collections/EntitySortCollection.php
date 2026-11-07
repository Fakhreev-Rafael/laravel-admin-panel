<?php

declare(strict_types=1);

namespace App\Collections;

use App\Models\EntitySort;
use Illuminate\Database\Eloquent\Collection;
use LogicException;

class EntitySortCollection extends Collection
{
    /**
     * Resolve the recieved sort.
     * 
     * @param ?string $sort
     * 
     * @return \App\Models\EntitySort
     */
    public function resolve(?string $sort): EntitySort
    {
        $selected = $this->first(
            fn (EntitySort $item) =>
                "{$item->field}_{$item->direction}" === $sort
        );

        $selected ??= $this->firstWhere('is_default', true);

        return $selected
            ?? throw new LogicException('Default sorting not found');
    }
}