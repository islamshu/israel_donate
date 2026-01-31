<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutFeature extends Model
{
    protected $table = 'about_features';

    protected $fillable = [
        'icon',
        'title',
        'description',
        'order',
        'is_active',
    ];
}
