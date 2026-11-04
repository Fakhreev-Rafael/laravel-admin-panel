<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EntityField extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'entity_id',
        'field',
    ];

    /**
     * Get the entity.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * Get the actions.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions(): HasMany
    {
        return $this->hasMany(EntityFieldAction::class);
    }

    /**
     * Get the sort.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sort(): HasOne
    {
        return $this->hasOne(EntitySort::class);
    }
}
