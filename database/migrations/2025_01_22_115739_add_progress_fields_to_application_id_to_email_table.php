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
        Schema::table('application_id_to_email', function (Blueprint $table) {
            $table->float('last_progress', 5, 2)->default(0)->comment('Stores the percentage progress, e.g., 30.2');
            $table->unsignedInteger('last_count_progress')->default(0)->comment('Counts the number of times progress remains the same');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_id_to_email', function (Blueprint $table) {
            $table->dropColumn(['last_progress', 'last_count_progress', 'deleted_at']);
        });
    }
};
