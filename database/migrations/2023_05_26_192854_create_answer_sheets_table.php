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
        Schema::create('answer_sheets', function (Blueprint $table) {
            $table->id();

            $table->json('answers')->nullable();



            $table->unsignedTinyInteger('status')->nullable();

            $table->float('score')->nullable()  ;

            $table->dateTime('finished_at')->nullable();
            





            $table->unsignedBigInteger('quizze_id')->nullable();
            $table->foreign('quizze_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_sheets');
    }
};
