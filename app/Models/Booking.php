<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'order_id',
        'consultant_id',
        'date',
        'start_time',
        'end_time',

        'client_name',
        'client_phone',
        'client_email',
        'client_age',
        'client_address',

        'amount_baisa',
        'currency',

        'thawani_session_id',
        'thawani_invoice',
        'thawani_payment_id',

        'status',
        'paid_at',
    ];

    protected $casts = [
        'date' => 'date',
        'paid_at' => 'datetime',
    ];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
}
