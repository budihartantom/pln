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
        Schema::create('pengukurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gardu_id')->constrained('gardus')->onDelete('cascade');
            $table->decimal('beban_trafo_kva', 10, 2);
            $table->decimal('beban_trafo_persen', 5, 2);
            $table->decimal('tegangan_fn_rata2', 8, 2);
            $table->decimal('cosphi_rata2', 4, 3);
            $table->decimal('unbalance_persen', 5, 2);
            $table->time('jam_pengukuran');
            $table->date('tanggal_pengukuran');
            $table->string('user_input')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengukurans');
    }
};
