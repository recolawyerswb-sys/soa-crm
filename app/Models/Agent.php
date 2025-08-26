<?php

namespace App\Models;

use App\Traits\AgentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agent extends Model
{
    use HasFactory, AgentTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position',
        'no_calls',
        'status',
        'is_leader',
        'team_id',
        'profile_id',
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
            'is_leader' => 'boolean',
            'team_id' => 'integer',
            'profile_id' => 'integer',
        ];
    }

    public static function getDefaultAgentId(): ?int
    {
        return Agent::whereHas('profile', function ($query) {
            $query->where('full_name', 'crm_agent');
        })->first()?->id;
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }
}
