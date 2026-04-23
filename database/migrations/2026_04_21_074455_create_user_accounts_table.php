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
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->enum('role', ['Patient', 'Staff', 'Admin']);
            
            // Foreign Keys
            $table->foreignId('patient_id')
                  ->nullable()
                  ->constrained('patients', 'patient_id')
                  ->onDelete('cascade');

            $table->foreignId('staff_id')
                  ->nullable()
                  ->constrained('staff', 'staff_id')
                  ->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_accounts');
    }
};
