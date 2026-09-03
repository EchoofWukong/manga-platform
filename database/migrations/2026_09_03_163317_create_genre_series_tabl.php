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
    Schema::create('genre_series', function (Blueprint $table) {
        $table->id();
        $table->foreignId('series_id')->constrained('series')->onDelete('cascade');
        $table->foreignId('genre_id')->constrained('genres')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre_series_tabl');
    }
};
