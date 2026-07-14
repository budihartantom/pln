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
        Schema::create('gardus', function (Blueprint $table) {
            $table->id();
            $table->string('id_gardu')->unique();
            $table->string('no_gardu')->unique();
            $table->string('id_up3');
            $table->string('up3');
            $table->string('id_ulp');
            $table->string('ulp');
            $table->string('penyulang');
            $table->string('alamat')->nullable();
            $table->string('kode_konstruksi');
            $table->string('status_pemilik');
            $table->integer('tahun_pembuatan');
            $table->string('merk')->nullable();
            $table->string('no_seri')->nullable();
            $table->decimal('kapasitas_trafo_kva', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gardus');
    }
};
