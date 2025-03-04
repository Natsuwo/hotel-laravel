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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('gallery_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category', 100);
            $table->integer('stock_quantity');
            $table->integer('reorder_level')->default(10);
            $table->integer('safety_stock')->default(10);
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('selling_price', 10, 2)->default(0);
            $table->date('last_order_date')->nullable();
            $table->date('last_received_date')->nullable();
            $table->foreign('supplier_id')
                ->references('id')
                ->on('inventory_supplier')
                ->onDelete('set null');
            $table->foreign('gallery_id')
                ->references('id')
                ->on('galleries')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
