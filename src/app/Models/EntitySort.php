<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntitySort extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'entity_field_id',
        'is_default',
        'default_direction',
        'allow_asc',
        'allow_desc',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'allow_asc' => 'boolean',
            'allow_desc' => 'boolean',
        ];
    }

    /**
     * Get the field.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(EntityField::class, 'entity_field_id');
    }
}
