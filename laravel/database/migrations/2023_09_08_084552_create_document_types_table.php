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
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('max_docs', false, true)->default(1);
            $table->boolean('restricts_access')->default(false);
            $table->string('type')->default(config('constants.TYPE_DOCUMENT_TYPE_ES.0'));
            $table->unsignedBigInteger('expiration_id');
            $table->unsignedBigInteger('entity_id');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('expiration_id')
                ->references('id')
                ->on('expirations');

            $table->foreign('entity_id')
                ->references('id')
                ->on('entities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_types');
    }
};
