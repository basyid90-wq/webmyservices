<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_counters', function (Blueprint $table) {
            $table->id();
            $table->string('doc_type', 20);
            $table->integer('y');
            $table->integer('m');
            $table->integer('last_seq')->default(0);
            $table->timestamps();
            $table->unique(['doc_type', 'y', 'm']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_counters');
    }
};
