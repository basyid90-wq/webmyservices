<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Order items: set product_id to nullable so product can be deleted without losing order history
        Schema::table('shop_order_items', function (Blueprint $table) {
            $table->dropForeign('shop_order_items_shop_product_id_foreign');
        });
        Schema::table('shop_order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('shop_product_id')->nullable()->change();
            $table->foreign('shop_product_id')->references('id')->on('shop_products')->nullOnDelete();
        });

        // Cart items: cascade delete when product is deleted
        Schema::table('shop_cart_items', function (Blueprint $table) {
            $table->dropForeign('shop_cart_items_shop_product_id_foreign');
            $table->foreign('shop_product_id')->references('id')->on('shop_products')->cascadeOnDelete();
        });
    }
};
