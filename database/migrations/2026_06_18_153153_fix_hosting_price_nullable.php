<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->decimal('domain_price_cost', 10, 2)->default(0.00)->nullable()->change();
            $table->decimal('domain_price_sell', 10, 2)->default(0.00)->nullable()->change();
            $table->decimal('hosting_price_cost', 10, 2)->default(0.00)->nullable()->change();
            $table->decimal('hosting_price_sell', 10, 2)->default(0.00)->nullable()->change();
        });
    }

    public function down(): void
    {
        //
    }
};
