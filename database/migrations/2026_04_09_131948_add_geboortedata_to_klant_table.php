<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Voeg JSON kolommen toe voor geboortedata van volwassenen, kinderen en baby's.
     */
    public function up(): void
    {
        Schema::table('klant', function (Blueprint $table) {
            $table->json('geboortedata_volwassenen')->nullable()->after('aantal_volwassenen');
            $table->json('geboortedata_kinderen')->nullable()->after('aantal_kinderen');
            $table->json('geboortedata_babys')->nullable()->after('aantal_babys');
        });
    }

    /**
     * Verwijder de kolommen weer als migration wordt teruggedraaid.
     */
    public function down(): void
    {
        Schema::table('klant', function (Blueprint $table) {
            $table->dropColumn([
                'geboortedata_volwassenen',
                'geboortedata_kinderen',
                'geboortedata_babys',
            ]);
        });
    }
};