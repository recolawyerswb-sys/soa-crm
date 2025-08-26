<?php

namespace App\Models\Saved;

use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    public $incrementing = false; // Use string IDs
    protected $keyType = 'string'; // Specify the key type as string

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($wallet) {
            if (empty($wallet->id)) {
                $wallet->id = (new Client())->generateId();
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coin_currency',
        'address',
        'network',
        'balance',
        'total_withdrawn',
        'total_ammount',
        'last_movement_id',
        'customer_id',
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
            'balance' => 'decimal',
            'total_withdrawn' => 'decimal',
            'total_ammount' => 'decimal',
            'last_movement_id' => 'integer',
            'customer_id' => 'integer',
        ];
    }

    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }
}
