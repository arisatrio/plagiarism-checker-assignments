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
        Schema::create('assignment_check_result_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('assignment_title');
            $table->date('assignment_date');
            $table->integer('shingle_size');
            $table->integer('total_files');
            $table->integer('total_comparisons');
            $table->float('average_similarity', 8, 4)->nullable();
            $table->float('highest_similarity', 8, 4)->nullable();
            $table->float('lowest_similarity', 8, 4)->nullable();
            $table->float('threshold', 8, 4)->nullable();
            $table->float('execution_time', 8, 4)->nullable();
            $table->timestamp('checked_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_check_result_summaries');
    }
};
