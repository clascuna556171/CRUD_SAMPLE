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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->string('reference_number', 50)->unique();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('assigned_doctor_id');
            $table->unsignedBigInteger('processed_by_id')->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending');
            $table->timestamp('booking_timestamp')->useCurrent();

            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
            $table->foreign('schedule_id')->references('schedule_id')->on('schedules')->onDelete('restrict');
            $table->foreign('assigned_doctor_id')->references('staff_id')->on('staff')->onDelete('restrict');
            $table->foreign('processed_by_id')->references('staff_id')->on('staff')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
