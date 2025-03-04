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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 100)->unique();
            $table->string('name', 100);
            $table->string('gender', 10)->nullable();
            $table->date('dob')->nullable();
            $table->string('email', 100)->unique();
            $table->string('provider', 100)->nullable(); // google, facebook, etc
            $table->string('password', 255)->nullable();
            $table->string('phone', 20)->unique();
            $table->string('address', 255)->nullable();
            $table->string('nationality', 100)->nullable();
            $table->string('passport', 100)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->unsignedBigInteger('point')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
