<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('quick_consultation_replies', function (Blueprint $table) {
            $table->enum('reply_type', ['client', 'consultant', 'admin'])->default('client')->after('reply_text');
            $table->string('admin_name')->nullable();
            $table->string('client_name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('quick_consultation_replies', function (Blueprint $table) {
            $table->dropColumn(['reply_type', 'admin_name', 'client_name']);
        });
    }
};
