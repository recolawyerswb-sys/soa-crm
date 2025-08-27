<?php

namespace App\Models;

use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    use HasFactory;

    protected $keyType = 'string'; // Specify the key type as string
    public $incrementing = false; // Use string IDs

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

        'bank_network',
        'account_number',
        'card_number',
        'cvc_code',
        'exp_date',

        'balance',
        'total_withdrawn',
        'total_deposit',
        'last_movement_id',
        'user_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'balance' => 'decimal:2',
            'total_withdrawn' => 'decimal:2',
            'total_deposit' => 'decimal:2',
            'last_movement_id' => 'integer',
            'user_id' => 'integer',
        ];
    }

    public static function getTotalAccBalance(): float
    {
        return self::query()->sum('balance');
    }

    public function addBalance($amount, $movementId): void
    {
        DB::transaction(function () use ($amount, $movementId) {
            $this->balance += $amount;
            $this->total_deposit = $this->balance + $amount;
            $this->last_movement_id = $movementId;
            $this->save();
        });
    }

    public function lessBalance($amount, $movementId): void
    {
        DB::transaction(function () use ($amount, $movementId) {
            $this->balance -= $amount;
            $this->total_withdrawn = $this->balance - $amount;
            $this->last_movement_id = $movementId;
            $this->save();
        });
    }

    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class, 'wallet_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
