<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quick_consultations', function (Blueprint $table) {
            $table->id();
            $table->string('consultation_number')->unique(); // رقم الاستشارة
            $table->foreignId('consultant_id')->constrained()->cascadeOnDelete();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone');
            $table->text('consultation_text');
            $table->enum('status', ['pending','answered','closed'])->default('pending');
            $table->timestamps();
        });

        Schema::create('quick_consultation_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('quick_consultations')->cascadeOnDelete();
            $table->text('reply_text');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // المستشار أو الادمن
            $table->timestamps();
        });

        Schema::create('quick_consultation_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('quick_consultations')->cascadeOnDelete();
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quick_consultation_files');
        Schema::dropIfExists('quick_consultation_replies');
        Schema::dropIfExists('quick_consultations');
    }
};