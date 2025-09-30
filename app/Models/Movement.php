<?php

namespace App\Models;

use App\Enums\Accounts\Movements\MovementType;
use App\Traits\Notifies;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Features\SupportEvents\Event;

class Movement extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($movement) {
            do {
                $id = substr(hash('sha256', uniqid(Str::random(10), true)), 0, 8);
            } while (self::where('id', $id)->exists());

            $movement->id = $id;
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'type',
        'status',
        'note',
        'wallet_id',
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
            'amount' => 'decimal:2',
            'wallet_id' => 'string',
        ];
    }

    /**
     * Aprobar o desaprobar el movimiento.
     */
    public function approve(): void
    {
        DB::transaction(function () {
            if ($this->status === '1' ) {
                // Ya está aprobado, no hacer nada.
                throw new \Exception('El movimiento ya fue aprobado.', 400);
            }

            if ($this->status === '0' ) {
                // Ya está aprobado, no hacer nada.
                throw new \Exception('El movimiento ya fue rechazado.', 400);
            }

            if ($this->type === '1' || $this->type === '3') {
                // Si es un depósito o bono, añadir balance a la wallet.
                $this->wallet->addBalance($this->amount, $this->id);
            } elseif ($this->type === '2' && $this->status !== '1') {
                // Si es un retiro y no está aprobado, restar balance a la wallet.
                if ($this->wallet->balance < $this->amount) {
                    // No hay suficiente balance para aprobar el retiro.
                    throw new \Exception('No hay suficiente balance en la wallet para aprobar este retiro.');
                }
                $this->wallet->lessBalance($this->amount, $this->id);
            }
            $this->status = '1';
            $this->save();
        });
    }

    public function decline(): void
    {
        if ($this->status === '0' ) {
            // Ya está aprobado, no hacer nada.
            throw new \Exception('El movimiento ya fue rechazado.', 400);
        }

        DB::transaction(function () {
            $this->status = '0';
            $this->save();
        });
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }
}
