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
        Schema::create('assignment_check_result_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('summary_id');
            $table->string('file1');
            $table->string('file2');
            $table->float('similarity', 8, 4);
            $table->string('similarity_score');
            $table->timestamps();

            $table->foreign('summary_id')
                ->references('id')->on('assignment_check_result_summaries')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_check_result_details');
    }
};
