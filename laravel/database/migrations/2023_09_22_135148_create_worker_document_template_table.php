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
        Schema::create('worker_document_template', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->references('id')->on('workers');
            $table->foreignId('document_template_id')->references('id')->on('document_templates');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_document_template');
    }
};
