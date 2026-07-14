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
        Schema::table('saw_run_details', function (Blueprint $table) {
            $table->decimal('d_plus', 16, 8)->nullable()->after('nilai_preferensi');
            $table->decimal('d_min', 16, 8)->nullable()->after('d_plus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saw_run_details', function (Blueprint $table) {
            $table->dropColumn(['d_plus', 'd_min']);
        });
    }
};
