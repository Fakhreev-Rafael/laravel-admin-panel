<?php

namespace App\Models;

use App\Collections\EntitySortCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EntitySort extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'entity',
        'field',
        'direction',
        'is_active',
        'is_default',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ];
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = []): Collection
    {
        return new EntitySortCollection($models);
    }
}
