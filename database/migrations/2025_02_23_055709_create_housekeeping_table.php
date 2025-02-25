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
        Schema::create('housekeeping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->enum('status', [
                'ready',
                'cleaning_in_progress',
                'needs_cleaning',
                'needs_inspection',
                'inspection_in_progress',
                'needs_maintenance',
                'maintenance_in_progress',
            ])->default('ready');
            $table->text('notes')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('booking_id')->references('id')->on('reservations')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housekeeping');
    }
};
