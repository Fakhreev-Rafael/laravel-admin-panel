<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntityFieldAction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'entity_field_id',
        'action',
    ];

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
