<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'phase',
        'origin',
        'status',
        'no_calls',
        'last_contact_at',
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
            'last_contact_at' => 'datetime',
            'profile_id' => 'integer',
        ];
    }

    public static function getCustomersCount(): int
    {
        return self::count();
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function assignment(): HasOne
    {
        return $this->hasOne(Assignment::class);
    }

    public function deleteWithRelations()
    {
        DB::transaction(function () {
            if ($this->profile && $this->profile->user && $this->profile->user->wallet) {
                foreach ($this->profile->user->wallet->movements as $movement) {
                    dd(
                        $movement
                    );
                }

                $this->profile->user->wallet->delete();
                $this->profile->user->delete();
                $this->profile->delete();
            }

            if ($this->assignment) {
                $this->assignment->delete();
            }

            $this->delete();
        });
    }
}
