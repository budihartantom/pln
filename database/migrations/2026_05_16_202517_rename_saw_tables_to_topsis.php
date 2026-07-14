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
        // 1. Drop foreign keys first to allow renaming
        Schema::table('saw_run_details', function (Blueprint $table) {
            $table->dropForeign(['saw_run_id']);
            $table->dropForeign(['gardu_id']);
        });

        Schema::table('saw_run_normalized', function (Blueprint $table) {
            $table->dropForeign(['saw_run_id']);
            $table->dropForeign(['gardu_id']);
            $table->dropForeign(['kriteria_id']);
        });

        Schema::table('saw_bobots', function (Blueprint $table) {
            $table->dropForeign(['kriteria_id']);
        });

        // 2. Rename tables
        Schema::rename('saw_runs', 'topsis_runs');
        Schema::rename('saw_run_details', 'topsis_run_details');
        Schema::rename('saw_run_normalized', 'topsis_run_normalizeds');
        Schema::rename('saw_kriterias', 'topsis_kriterias');
        Schema::rename('saw_bobots', 'topsis_bobots');

        // 3. Rename columns and re-add foreign keys
        Schema::table('topsis_run_details', function (Blueprint $table) {
            $table->renameColumn('saw_run_id', 'topsis_run_id');
        });
        Schema::table('topsis_run_details', function (Blueprint $table) {
            $table->foreign('topsis_run_id')->references('id')->on('topsis_runs')->onDelete('cascade');
            $table->foreign('gardu_id')->references('id')->on('gardus')->onDelete('cascade');
        });

        Schema::table('topsis_run_normalizeds', function (Blueprint $table) {
            $table->renameColumn('saw_run_id', 'topsis_run_id');
        });
        Schema::table('topsis_run_normalizeds', function (Blueprint $table) {
            $table->foreign('topsis_run_id')->references('id')->on('topsis_runs')->onDelete('cascade');
            $table->foreign('gardu_id')->references('id')->on('gardus')->onDelete('cascade');
            $table->foreign('kriteria_id')->references('id')->on('topsis_kriterias')->onDelete('cascade');
        });

        Schema::table('topsis_bobots', function (Blueprint $table) {
            $table->foreign('kriteria_id')->references('id')->on('topsis_kriterias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topsis', function (Blueprint $table) {
            //
        });
    }
};
