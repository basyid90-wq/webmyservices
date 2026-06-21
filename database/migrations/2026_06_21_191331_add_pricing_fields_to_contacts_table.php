<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('plan_name')->nullable()->after('id');
            $table->string('company_name')->nullable()->after('name');
            $table->string('whatsapp')->nullable()->after('email');
            $table->string('industry')->nullable()->after('subject');
            $table->string('website_goal')->nullable()->after('industry');
            $table->text('reference_urls')->nullable()->after('website_goal');
            $table->string('content_status')->nullable()->after('reference_urls');
            $table->decimal('additional_budget', 10, 2)->nullable()->after('content_status');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn([
                'plan_name',
                'company_name',
                'whatsapp',
                'industry',
                'website_goal',
                'reference_urls',
                'content_status',
                'additional_budget',
            ]);
        });
    }
};
