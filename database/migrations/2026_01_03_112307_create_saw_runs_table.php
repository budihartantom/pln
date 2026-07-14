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
        Schema::create('saw_runs', function (Blueprint $table) {
            $table->id();
            $table->date('periode_mulai');
            $table->date('periode_selesai');
            $table->string('metode')->default('SAW');
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saw_runs');
    }
};
