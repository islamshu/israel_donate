<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickConsultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_number',
        'consultant_id',
        'client_name',
        'client_email',
        'client_phone',
        'consultation_text',
        'status',
    ];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function replies()
    {
        return $this->hasMany(QuickConsultationReply::class, 'consultation_id');
    }

    public function files()
    {
        return $this->hasMany(QuickConsultationFile::class, 'consultation_id');
    }

    // توليد رقم فريد تلقائي
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->consultation_number = 'QC' . strtoupper(uniqid());
        });
    }
}