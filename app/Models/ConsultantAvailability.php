<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantAvailability extends Model
{
    protected $fillable = [
        'consultant_id',
        'day_of_week',
        'start_time',
        'end_time',
        'slot_duration',
    ];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
}
