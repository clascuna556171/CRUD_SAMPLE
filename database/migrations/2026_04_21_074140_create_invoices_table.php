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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('invoice_id');
            $table->unsignedBigInteger('appointment_id')->unique();
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->enum('payment_status', ['Unpaid', 'Paid', 'Partially Paid', 'Cancelled'])->default('Unpaid');
            $table->timestamp('issued_date')->useCurrent();

            $table->foreign('appointment_id')->references('appointment_id')->on('appointments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
