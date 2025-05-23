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
        Schema::table('repences', function (Blueprint $table) {
            // Drop existing columns that we don't need
            $table->dropForeign(['variable_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['agency_id']);
            $table->dropForeign(['admin_id']);
            $table->dropColumn(['variable_id', 'user_id', 'agency_id', 'admin_id', 'value']);

            // Add new columns
            $table->foreignId('dossier_id')->constrained()->onDelete('cascade');
            $table->foreignId('formuler_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['en_cours', 'agency', 'termine'])->default('en_cours');
            $table->json('answers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repences', function (Blueprint $table) {
            // Remove new columns
            $table->dropForeign(['dossier_id']);
            $table->dropForeign(['formuler_id']);
            $table->dropColumn(['dossier_id', 'formuler_id', 'status', 'answers']);

            // Restore original columns
            $table->foreignId('variable_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('agency_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('admin_id')->nullable()->constrained()->onDelete('set null');
            $table->text('value');
        });
    }
};
