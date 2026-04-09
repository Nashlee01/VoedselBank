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
        Schema::table('klant', function (Blueprint $table) {
            if (!Schema::hasColumn('klant', 'geboortedata_volwassenen')) {
                $table->text('geboortedata_volwassenen')->nullable()->after('aantal_volwassenen');
            }
            if (!Schema::hasColumn('klant', 'geboortedata_babys')) {
                $table->text('geboortedata_babys')->nullable()->after('aantal_babys');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('klant', function (Blueprint $table) {
            if (Schema::hasColumn('klant', 'geboortedata_volwassenen')) {
                $table->dropColumn('geboortedata_volwassenen');
            }
            if (Schema::hasColumn('klant', 'geboortedata_babys')) {
                $table->dropColumn('geboortedata_babys');
            }
        });
    }
};
