<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
    {
        Schema::table('consultants', function (Blueprint $table) {
            // إزالة القيمة الافتراضية من user_id
            $table->foreignId('user_id')->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('consultants', function (Blueprint $table) {
            // إعادة القيمة الافتراضية 1 (إذا أردت التراجع)
            $table->foreignId('user_id')->default(1)->change();
        });
    }
};
