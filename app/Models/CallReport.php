<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallReport extends Model
{
    protected $fillable = [
        'call_sid',
        'call_status',
        'call_notes',
        'customer_phase',
        'customer_status',
        'assignment_id',
        'user_id',
    ];

    protected $casts = [
        'assignment_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
