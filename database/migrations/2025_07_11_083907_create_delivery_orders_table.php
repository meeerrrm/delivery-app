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
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_number');
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('truck_id')->constrained();
            $table->foreignId('origin_id')->constrained('locations');
            $table->foreignId('destination_id')->constrained('locations');
            $table->string('item_name');
            $table->integer('item_quantity');
            $table->string('item_type');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_orders');
    }
};
