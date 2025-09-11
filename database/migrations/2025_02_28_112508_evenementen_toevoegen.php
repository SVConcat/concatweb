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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('titel')->nullable();
            $table->string('categorie');
            $table->date('datum')->nullable();
            $table->date('einddatum')->nullable();
            $table->time('starttijd')->nullable();
            $table->time('eindtijd')->nullable();
            $table->text('beschrijving')->nullable();
            $table->string('locatie')->nullable();
            $table->integer('aantal_beschikbare_plekken')->nullable();
            $table->string('betaal_link')->nullable();
            $table->timestamps();
            $table->string('afbeelding')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
