<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    protected $fillable = [
        'name',
        'title',
        'image',
        'rating',
        'years_experience',
        'description',
        'price',
        'order',
        'is_active',
    ];
    public function availabilities()
    {
        return $this->hasMany(ConsultantAvailability::class);
    }

    public function dateOverrides()
    {
        return $this->hasMany(ConsultantDateOverride::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
