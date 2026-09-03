<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    // Kullanıcılara rol (admin, uploader, user) ekliyoruz
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('user')->after('email');
    });

    // Bölümlere birden fazla resim ekleyebilmek için JSON sütunu ekliyoruz
    Schema::table('chapters', function (Blueprint $table) {
        $table->json('images')->nullable()->after('is_locked');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
