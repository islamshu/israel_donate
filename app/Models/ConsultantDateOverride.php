<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantDateOverride extends Model
{
    protected $fillable = [
        'consultant_id',
        'date',
        'start_time',
        'end_time',
        'is_available',
    ];

    protected $casts = [
        'date' => 'date',
        'is_available' => 'boolean',
    ];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
}
