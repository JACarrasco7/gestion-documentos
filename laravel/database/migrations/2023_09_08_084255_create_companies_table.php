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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cif');
            $table->string('experience'); //Number years
            $table->unsignedBigInteger('especialty_id');
            $table->unsignedBigInteger('document_template_id');
            $table->unsignedBigInteger('contact_info_id');
            $table->timestamps();

            $table->foreign('especialty_id')
                ->references('id')
                ->on('especialties');

            $table->foreign('document_template_id')
                ->references('id')
                ->on('document_templates');

            $table->foreign('contact_info_id')
                ->references('id')
                ->on('contact_info')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
