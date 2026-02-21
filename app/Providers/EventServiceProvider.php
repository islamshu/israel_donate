<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\QuickConsultationCreated;
use App\Listeners\SendQuickConsultationEmails;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        QuickConsultationCreated::class => [
            SendQuickConsultationEmails::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }
}