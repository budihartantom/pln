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
        Schema::create('saw_run_normalized', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saw_run_id')->constrained('saw_runs')->onDelete('cascade');
            $table->foreignId('gardu_id')->constrained('gardus')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('saw_kriterias')->onDelete('cascade');
            $table->decimal('nilai_x', 10, 4);
            $table->decimal('nilai_r', 10, 4);
            $table->decimal('kontribusi', 10, 4); // wj * rij
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saw_run_normalized');
    }
};
