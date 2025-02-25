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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id', 255)->unique();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('guest_id');
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->unsignedBigInteger('duration');
            $table->unsignedBigInteger('adults');
            $table->unsignedBigInteger('children');
            $table->unsignedInteger('status'); // 0 = pending, 1 = approved, 2 = rejected
            $table->text('notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->foreign('room_id')
                ->references('id')
                ->on('rooms')
                ->onDelete('cascade');
            $table->foreign('guest_id')
                ->references('id')
                ->on('guests')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
