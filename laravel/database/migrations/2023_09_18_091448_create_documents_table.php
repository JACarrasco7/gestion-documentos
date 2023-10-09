<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('path');
            $table->foreignId('document_type_id')->references('id')->on('document_types');
            $table->foreignId('entity_id')->references('id')->on('entities');
            $table->foreignId('build_id')->references('id')->on('builds');
            $table->timestamp('expirate_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
