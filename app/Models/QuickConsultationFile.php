<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickConsultationFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'file_path',
    ];

    public function consultation()
    {
        return $this->belongsTo(QuickConsultation::class, 'consultation_id');
    }
}