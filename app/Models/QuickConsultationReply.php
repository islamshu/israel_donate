<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickConsultationReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'reply_text',
        'user_id',
        'reply_type',    // client / admin / consultant
        'admin_name',
        'client_name',
    ];

    // العلاقة مع الاستشارة
    public function consultation()
    {
        return $this->belongsTo(QuickConsultation::class, 'consultation_id');
    }

    // العلاقة مع المستخدم إذا كان مسجل
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // دالة مساعدة لإظهار اسم من رد
    public function getResponderNameAttribute()
    {
        return match($this->reply_type) {
            'admin' => $this->admin_name ?? 'الإدارة',
            'consultant' => $this->admin_name ?? 'المستشار',
            default => $this->client_name ?? 'المستخدم',
        };
    }

    // دالة مساعدة لتحديد نوع الرد للعرض (لون أو badge)
    public function getResponderTypeBadgeAttribute()
    {
        return match($this->reply_type) {
            'admin' => ['label' => 'Admin', 'class' => 'badge-light text-primary'],
            'consultant' => ['label' => 'Consultant', 'class' => 'badge-light text-info'],
            default => ['label' => 'Client', 'class' => 'badge-light text-success'],
        };
    }
}