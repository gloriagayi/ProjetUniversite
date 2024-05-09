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
        Schema::create('universite', function (Blueprint $table) {
            $table->id();
            $table->string('Nom')->nullable();
            $table->string('Adresse');
            $table->string('Informations_contact')->nullable();
            $table->text('Description');
            $table->text('Programmes_etudes');
            $table->text('Infrastructures');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universite');
    }
};
