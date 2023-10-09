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
        Schema::create('build_company', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('build_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->foreign('build_id')
                ->references('id')
                ->on('builds')
                ->onDelete('cascade');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('build_company');
    }
};
