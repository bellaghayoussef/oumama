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
        Schema::create('formuler_question_variable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formuler_question_id')->references('id')->on('formuler_question')->cascadeOnDelete();
            $table->foreignId('variable_id')->constrained()->cascadeOnDelete();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formuler_question_variable');
    }
}; 