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
        Schema::create('promoters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(1);
            $table->string('contact_name_1')->nullable();
            $table->string('contact_email_1')->nullable();
            $table->string('contact_name_2')->nullable();
            $table->string('contact_email_2')->nullable();
            $table->unsignedBigInteger('contact_info_id');
            $table->timestamps();

            $table->foreign('contact_info_id')
                ->references('id')
                ->on('contact_info');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promoters');
    }
};
