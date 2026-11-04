<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntityActionScope extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'entity_action_id',
        'scope',
    ];

    /**
     * Get the action.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entityAction(): BelongsTo
    {
        return $this->belongsTo(EntityAction::class);
    }
}
