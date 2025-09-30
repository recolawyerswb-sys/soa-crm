<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    public function agents(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'agent_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'day_week' => 'integer',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'agent_id' => 'integer',
        ];
    }
}
