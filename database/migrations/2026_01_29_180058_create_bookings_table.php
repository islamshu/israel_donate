<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('consultant_id')->constrained()->cascadeOnDelete();

            $table->date('date');

            $table->time('start_time');
            $table->time('end_time');

            // Client
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('client_email')->nullable();
            $table->unsignedSmallInteger('client_age')->nullable();
            $table->string('client_address')->nullable();

            $table->unsignedInteger('amount_baisa');
            $table->string('currency', 3)->default('OMR');

            $table->string('thawani_session_id')->nullable()->index();
            $table->string('thawani_invoice')->nullable()->index();
            $table->string('thawani_payment_id')->nullable()->index();

            $table->string('status')->default('pending'); // pending|paid|canceled|failed|expired
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->unique(['consultant_id', 'date', 'start_time'], 'uniq_booking_slot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
