<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->enum('doc_type', ['QUOTE', 'INVOICE', 'RECEIPT']);
            $table->string('doc_no', 50)->unique();
            $table->date('doc_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('valid_until')->nullable();
            $table->string('status', 50)->default('Draft');
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->string('bill_to_name')->nullable();
            $table->string('bill_to_email')->nullable();
            $table->string('bill_to_phone', 50)->nullable();
            $table->text('bill_to_address')->nullable();
            $table->text('notes')->nullable();
            $table->string('currency', 10)->default('MYR');
            $table->decimal('subtotal', 12, 2)->default(0.00);
            $table->decimal('discount_amount', 12, 2)->default(0.00);
            $table->decimal('tax_percent', 5, 2)->default(0.00);
            $table->decimal('tax_amount', 12, 2)->default(0.00);
            $table->decimal('grand_total', 12, 2)->default(0.00);
            $table->decimal('paid_amount', 12, 2)->default(0.00);
            $table->string('payment_method')->nullable();
            $table->string('payment_ref')->nullable();
            $table->foreignId('related_doc_id')->nullable()->constrained('documents')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
