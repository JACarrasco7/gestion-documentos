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
        Schema::create('document_template_document_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_template_id');
            $table->unsignedBigInteger('document_type_id');
            $table->timestamps();

            $table->foreign('document_template_id')
                ->references('id')
                ->on('document_templates')
                ->onDelete('cascade');

            $table->foreign('document_type_id')
                ->references('id')
                ->on('document_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_template_document_type');
    }
};
