<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('pic_name')->nullable()->after('notes');
            $table->string('website_type')->default('custom')->nullable()->after('pic_name');
            $table->string('domain_name')->nullable()->after('website_type');
            $table->string('domain_provider_url')->nullable()->after('domain_name');
            $table->string('domain_login')->nullable()->after('domain_provider_url');
            $table->string('domain_password')->nullable()->after('domain_login');
            $table->decimal('domain_price_cost', 10, 2)->default(0.00)->after('domain_password');
            $table->decimal('domain_price_sell', 10, 2)->default(0.00)->after('domain_price_cost');
            $table->date('domain_start_date')->nullable()->after('domain_price_sell');
            $table->date('domain_expiry_date')->nullable()->after('domain_start_date');
            $table->string('hosting_name')->nullable()->after('domain_expiry_date');
            $table->string('hosting_provider_url')->nullable()->after('hosting_name');
            $table->string('hosting_login')->nullable()->after('hosting_provider_url');
            $table->string('hosting_password')->nullable()->after('hosting_login');
            $table->decimal('hosting_price_cost', 10, 2)->default(0.00)->after('hosting_password');
            $table->decimal('hosting_price_sell', 10, 2)->default(0.00)->after('hosting_price_cost');
            $table->date('hosting_start_date')->nullable()->after('hosting_price_sell');
            $table->date('hosting_expiry_date')->nullable()->after('hosting_start_date');
            $table->string('wp_login')->nullable()->after('hosting_expiry_date');
            $table->string('wp_password')->nullable()->after('wp_login');
            $table->date('wp_last_plugin_update')->nullable()->after('wp_password');
            $table->string('status_renew')->default('aktif')->nullable()->after('wp_last_plugin_update');
            $table->boolean('is_subscription_active')->default(true)->after('status_renew');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'pic_name',
                'website_type',
                'domain_name',
                'domain_provider_url',
                'domain_login',
                'domain_password',
                'domain_price_cost',
                'domain_price_sell',
                'domain_start_date',
                'domain_expiry_date',
                'hosting_name',
                'hosting_provider_url',
                'hosting_login',
                'hosting_password',
                'hosting_price_cost',
                'hosting_price_sell',
                'hosting_start_date',
                'hosting_expiry_date',
                'wp_login',
                'wp_password',
                'wp_last_plugin_update',
                'status_renew',
                'is_subscription_active',
            ]);
        });
    }
};
