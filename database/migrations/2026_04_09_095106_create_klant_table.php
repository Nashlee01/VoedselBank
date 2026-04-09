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
        Schema::create('klant', function (Blueprint $table) {
            $table->id('klant_id');
            $table->string('gezinsnaam');
            $table->string('straat');
            $table->string('huisnummer');
            $table->string('toevoeging')->nullable();
            $table->string('postcode');
            $table->string('plaats');
            $table->string('telefoonnummer');
            $table->string('email')->unique();
            $table->integer('aantal_volwassenen')->default(0);
            $table->integer('aantal_kinderen')->default(0);
            $table->integer('aantal_babys')->default(0);
            $table->boolean('is_actief')->default(true);
            $table->timestamp('datum_aangemaakt')->useCurrent();
            $table->timestamp('datum_gewijzigd')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klant');
    }
};
