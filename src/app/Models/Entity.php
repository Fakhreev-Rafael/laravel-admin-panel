<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'slug',
        'model',
        'label',
        'owner_field',
    ];

    /**
     * Get the actions.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions(): HasMany
    {
        return $this->hasMany(EntityAction::class);
    }

    /**
     * Get the fields.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields(): HasMany
    {
        return $this->hasMany(EntityField::class);
    }

    /**
     * Get the record scopes.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recordScopes(): HasMany
    {
        return $this->hasMany(EntityRecordScope::class);
    }
}
