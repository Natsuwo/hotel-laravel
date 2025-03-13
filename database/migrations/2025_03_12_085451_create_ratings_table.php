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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id')->nullable();
            $table->unsignedBigInteger('room_type_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->decimal('rating', 2, 1)->check('rating >= 0.5 AND rating <= 5');
            $table->text('comment')->nullable();
            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('SET NULL');
            $table->foreign('room_type_id')->references('id')->on('room_types')->onDelete('SET NULL');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('SET NULL');
            $table->foreign('booking_id')->references('id')->on('reservations')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
