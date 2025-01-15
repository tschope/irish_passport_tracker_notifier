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
        Schema::create('application_id_to_email', function (Blueprint $table) {
            $table->id();
            $table->string('applicationId');
            $table->text('email'); // Usaremos text porque será criptografado
            $table->boolean('email_verified')->default(false);
            $table->time('send_time_1')->nullable();
            $table->time('send_time_2')->nullable();
            $table->boolean('weekends');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_id_to_email');
    }
};
