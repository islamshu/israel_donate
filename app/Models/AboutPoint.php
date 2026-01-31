<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPoint extends Model
{
    protected $table = 'about_points';

    protected $fillable = [
        'icon',
        'title',
        'description',
        'order',
    ];
    
}
