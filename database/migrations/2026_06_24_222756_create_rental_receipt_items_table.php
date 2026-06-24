<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_receipt_id')->constrained('rental_receipts')->onDelete('cascade');
            $table->string('category');
            $table->string('model_unit');
            $table->integer('quantity')->default(1);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration_days');
            $table->decimal('price_per_day', 10, 2);
            $table->enum('price_type', ['per_day', 'flat'])->default('per_day');
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_receipt_items');
    }
};
