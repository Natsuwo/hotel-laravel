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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->enum('status', ['paid', 'unpaid', 'failed', 'cancelled', 'refunded']);
            $table->enum('payment_method', ['cash', 'card', 'paypal', 'momo', 'bank_transfer', 'vnpay']);
            $table->string('transaction_id', 255)->unique();
            $table->timestamp('paid_at')->default(null)->nullable();
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
