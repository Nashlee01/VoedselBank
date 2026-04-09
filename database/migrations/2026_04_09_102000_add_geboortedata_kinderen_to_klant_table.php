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
            if (!Schema::hasColumn('klant', 'geboortedata_kinderen')) {
                $table->text('geboortedata_kinderen')->nullable()->after('aantal_kinderen');
            }
            if (Schema::hasColumn('klant', 'leeftijd_kinderen')) {
                $table->dropColumn('leeftijd_kinderen');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('klant', function (Blueprint $table) {
            if (!Schema::hasColumn('klant', 'leeftijd_kinderen')) {
                $table->string('leeftijd_kinderen')->nullable()->after('aantal_kinderen');
            }
            if (Schema::hasColumn('klant', 'geboortedata_kinderen')) {
                $table->dropColumn('geboortedata_kinderen');
            }
        });
    }
};
