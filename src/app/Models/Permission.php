<?php

namespace App\Models;

use App\Builders\PermissionBuilder;
use App\Collections\PermissionCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'slug',
        'entity',
        'action',
        'is_system',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_system' => 'boolean',
        ];
    }

    /**
     * Get the roles.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions')->withTimestamps();
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * 
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new PermissionBuilder($query);
    }

    /**
     * Return translated name of the permission.
     * 
     * @return string
     */
    public function getTranslatedName(): string
    {
        return trans('permissions.' . $this->slug);
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
        return new PermissionCollection($models);
    }
}
