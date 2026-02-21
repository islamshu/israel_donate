<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\QuickConsultationCreated;
use App\Listeners\SendQuickConsultationEmails;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // تسجيل الحدث مع Listener
        QuickConsultationCreated::class => [
            SendQuickConsultationEmails::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();
        // لو بدك أي boot logic إضافي، تحطه هنا
    }
}