<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewslettersTable extends Migration
{
    public function up()
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('titel')->unique();
            $table->date('publicatiedatum');
            $table->longText('inhoud'); // JSON van events
            $table->string('pdf')->nullable(); // pad naar PDF bestand
            $table->longText('images')->nullable(); // JSON met paths van afbeeldingen
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('newsletters');
    }
}
