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
            $table->id();
            $table->unsignedBigInteger('guest_id');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('booking_id');
            $table->float('price_per_night');
            $table->float('extras')->nullable();
            $table->unsignedInteger('nights');
            $table->float('discount')->nullable();
            $table->float('vat');
            $table->float('tax');
            $table->float('amount');
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->enum('status', ['paid', 'unpaid', 'partial', 'cancelled', 'refunded']);
            $table->foreign('guest_id')
                ->references('id')
                ->on('guests')
                ->onDelete('cascade');
            $table->foreign('room_id')
                ->references('id')
                ->on('rooms')
                ->onDelete('cascade');
            $table->foreign('booking_id')
                ->references('id')
                ->on('reservations')
                ->onDelete('cascade');
            $table->foreign('coupon_id')
                ->references('id')
                ->on('coupons')
                ->onDelete('set null');
            $table->timestamps();
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
