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
        Schema::create('build_external', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('build_id');
            $table->unsignedBigInteger('user_id'); //External
            $table->timestamps();

            $table->foreign('build_id')
                ->references('id')
                ->on('builds');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('build_external');
    }
};
