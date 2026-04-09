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
        Schema::create('voedselpakket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klant_id')->constrained('klant')->onDelete('cascade');
            $table->date('datum_uitgifte');
            $table->enum('status', ['uitgegeven', 'teruggebracht'])->default('uitgegeven');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voedselpakket');
    }
};
