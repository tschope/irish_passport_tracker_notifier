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
            $table->json('notification_days')->nullable()->after('weekends')
                ->comment('Stores the days of the week for notifications in JSON format');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_id_to_email', function (Blueprint $table) {
            $table->dropColumn('notification_days');
        });
    }
};
