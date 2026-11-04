<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EntityAction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'entity_id',
        'action',
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
     * Get the scopes.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scopes(): HasMany
    {
        return $this->hasMany(EntityActionScope::class);
    }
}
