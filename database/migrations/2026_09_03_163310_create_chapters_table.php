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
    Schema::create('chapters', function (Blueprint $table) {
        $table->id();
        $table->foreignId('series_id')->constrained('series')->onDelete('cascade');
        $table->decimal('chapter_number', 8, 1);
        $table->string('title')->nullable();
        $table->integer('price_coins')->default(0);
        $table->boolean('is_locked')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};
