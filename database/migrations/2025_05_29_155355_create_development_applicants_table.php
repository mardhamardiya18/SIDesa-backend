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
        Schema::create('development_applicants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('development_id');
            $table->foreign('development_id')
                ->references('id')
                ->on('developments')
                ->onDelete('cascade');
            $table->uuid('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('development_applicants');
    }
};
