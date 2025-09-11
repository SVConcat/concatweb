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
        Schema::create('evenementen_gallery', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
    $table->foreignId('gallery_id')->constrained('galleries')->onDelete('cascade');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evenementen_gallery');
    }
};
