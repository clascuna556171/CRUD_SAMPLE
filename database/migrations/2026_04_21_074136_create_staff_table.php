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
        Schema::create('staff', function (Blueprint $table) {
            $table->id('staff_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->enum('role', ['Doctor', 'Nurse', 'Admissions Clerk', 'Admin'])->default('Admissions Clerk');
            $table->string('specialization', 100)->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
