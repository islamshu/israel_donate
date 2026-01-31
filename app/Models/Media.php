<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'mime_type',
        'size',
        'width',
        'height',
        'title',
        'alt',
        'caption',
        'description',
    ];

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    public function getHumanSizeAttribute()
    {
        if (!$this->size) return null;
        return round($this->size / 1024, 2) . ' KB';
    }
}
