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
        Schema::create('delivery_order_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('delivery_order_id')->constrained();
            $table->enum('status', [
            'Pending', 'To Origin', 'Arrival to Origin',
            'On Load', 'To Destination', 'Arrival to Destination',
            'Unload', 'Done',
            ]);
            $table->text('note')->nullable();
            $table->string('document')->nullable();
            $table->foreignId('assessed_by')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_order_logs');
    }
};
