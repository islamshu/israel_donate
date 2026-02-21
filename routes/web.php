<?php

use App\Http\Controllers\AboutFeatureController;
use App\Http\Controllers\AboutPointController;
use App\Http\Controllers\AboutSectionController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConsultantAvailabilityController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\ConsultantScheduleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\DashbaordController;
use App\Http\Controllers\HomeHeroController;
use App\Http\Controllers\HomeServiceController;
use App\Http\Controllers\HomeStatController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\QuickConsultationController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Route for home page
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get(
    '/booking',
    [HomeController::class, 'booking']
)->name('booking.index');
Route::get('/consultation-query/{consultation_number?}', [QuickConsultationController::class, 'queryForm'])
    ->name('consultation.query.form');

    Route::get('create_users',[HomeController::class,"create_users"]);

Route::post('/consultation-query', [QuickConsultationController::class, 'queryResult'])
    ->name('consultation.query.result');

Route::post('/quick-consultation/{consultation}/client-reply', [QuickConsultationController::class, 'client_reply'])
    ->name('quick.consult.client_reply');

Route::get('/quick-booking', [QuickConsultationController::class, 'create'])
    ->name('quick.booking.form');

Route::post('/quick-booking', [QuickConsultationController::class, 'store'])
    ->name('quick.booking.store');

Route::get('/services',[HomeController::class, 'services']
)->name('services');
Route::get(
    'consultants/{consultant}/available-slots',
    [ConsultantScheduleController::class, 'availableSlots']
)->name('dashboard.consultants.available-slots');

Route::get('/bookings/check-slot', [CheckoutController::class, 'checkSlot'])
    ->name('bookings.check-slot');

Route::post('/checkout/thawani', [CheckoutController::class, 'create'])
    ->name('checkout.thawani');

Route::get('/checkout/thawani/success/{id}', [CheckoutController::class, 'success'])
    ->name('checkout.thawani.success');

Route::get('/checkout/thawani/cancel/{id}', [CheckoutController::class, 'cancel'])
    ->name('checkout.thawani.cancel');

Route::post('/contact/send', [ContactController::class, 'store'])
    ->name('contact.send');
/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::get('/login', [DashbaordController::class, 'login'])->name('login');
Route::post('/login', [DashbaordController::class, 'post_login'])->name('post_login');

/*
|--------------------------------------------------------------------------
| Dashboard (Admin Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['admin'])->prefix('dashboard')->group(function () {
    /*
    |----------------------------------------------------------------------
    | Dashboard Core
    |----------------------------------------------------------------------
    */
    Route::get('/', [DashbaordController::class, 'dashboard'])->name('dashboard');
    Route::get('/edit_profile', [DashbaordController::class, 'edit_profile'])->name('edit_profile');
    Route::post('/edit_profile', [DashbaordController::class, 'edit_profile_post'])->name('edit_profile_post');
    Route::post('/add_general', [DashbaordController::class, 'add_general'])->name('add_general');
    Route::get('/logout', [DashbaordController::class, 'logout'])->name('logout');
    Route::get('/general_setting', [DashbaordController::class, 'setting'])->name('settings.index');
    Route::get('/additinal_setting', [DashbaordController::class, 'additinal_setting'])->name('settings.additinal');
    Route::get('icons', fn() => view('dashboard.icons.index'))->name('icons.index');

    /*
    |----------------------------------------------------------------------
    | Media Library
    |----------------------------------------------------------------------
    */
    Route::prefix('media')->name('dashboard.media.')->group(function () {
        Route::get('/', [MediaController::class, 'index'])->name('index');
        Route::get('/grid', [MediaController::class, 'grid'])->name('grid');
        Route::post('/upload', [MediaController::class, 'upload'])->name('upload');
        Route::patch('/{media}', [MediaController::class, 'update'])->name('update');
        Route::delete('/{media}', [MediaController::class, 'destroy'])->name('destroy');
    });
    /*
    |----------------------------------------------------------------------
    | Here Section
    |----------------------------------------------------------------------
    */
    Route::get('/hero/edit', [HomeHeroController::class, 'edit'])
        ->name('hero.edit');
    Route::post('/hero/update', [HomeHeroController::class, 'update'])
        ->name('hero.update');
    /*
    |----------------------------------------------------------------------
    | statistic Section
    |----------------------------------------------------------------------
    */
    Route::get('home-stats', [HomeStatController::class, 'edit'])->name('home-stats.edit');
    Route::post('home-stats', [HomeStatController::class, 'update'])->name('home-stats.update');
    /*
    |----------------------------------------------------------------------
    | About section section
    |----------------------------------------------------------------------
    */
    Route::get('about', [AboutSectionController::class, 'edit'])
        ->name('dashboard.about.edit');
    Route::post('about', [AboutSectionController::class, 'update'])
        ->name('dashboard.about.update');
    /*
    |----------------------------------------------------------------------
    | HomeService section
    |----------------------------------------------------------------------
    */
    Route::resource('home-services', HomeServiceController::class)
        ->names('dashboard.home-services')->except(['show']);
    Route::post(
        '/home-services/toggle/{service}',
        [HomeServiceController::class, 'toggle']
    )->name('dashboard.home-services.toggle');
    /*
    |----------------------------------------------------------------------
    | HomeService section
    |----------------------------------------------------------------------
    */
    Route::resource(
        'consultants',
        ConsultantController::class
    )->names('dashboard.consultants');

    Route::post(
        'consultants/toggle/{consultant}',
        [ConsultantController::class, 'toggle']
    )->name('dashboard.consultants.toggle');
    /*
    |----------------------------------------------------------------------
    | HomeService section
    |----------------------------------------------------------------------
    */

    Route::get(
        'consultants/{consultant}/availability',
        [ConsultantAvailabilityController::class, 'edit']
    )->name('dashboard.consultants.availability.edit');

    Route::post(
        'consultants/{consultant}/availability',
        [ConsultantAvailabilityController::class, 'update']
    )->name('dashboard.consultants.availability.update');


    Route::get('/bookings', [BookingController::class, 'index'])
        ->name('dashboard.bookings.index');

    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->name('dashboard.bookings.show');



    Route::get('/quick-consultations', [QuickConsultationController::class, 'index'])
        ->name('dashboard.quick_consultations.index');
    
    // عرض استشارة محددة
    Route::get('/quick-consultations/{quickConsultation}', [QuickConsultationController::class, 'show'])
        ->name('dashboard.quick_consultations.show');
    
    // تحديث حالة الاستشارة
    Route::post('/quick-consultations/{quickConsultation}/status', [QuickConsultationController::class, 'updateStatus'])
        ->name('dashboard.quick_consultations.status');
    
    // إضافة رد من لوحة التحكم
    Route::post('/quick-consultations/{quickConsultation}/reply', [QuickConsultationController::class, 'reply'])
        ->name('dashboard.quick_consultations.reply');
    /*
    |----------------------------------------------------------------------
    | Contact Messages
    |----------------------------------------------------------------------
    */
    Route::get(
        'contact-messages',
        [ContactMessageController::class, 'index']
    )->name('dashboard.contact.index');

    Route::get(
        'contact-messages/{message}',
        [ContactMessageController::class, 'show']
    )->name('dashboard.contact.show');

    Route::delete(
        'contact-messages/{message}',
        [ContactMessageController::class, 'destroy']
    )->name('dashboard.contact.destroy');
});
