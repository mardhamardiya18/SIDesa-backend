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
        Schema::create('family_members', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('head_of_family_id')->unique();
            $table->foreignId('head_of_family_id')->constrained('head_of_families')->onDelete('cascade');

            $table->uuid('user_id')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('profile_picture')->nullable();
            $table->integer('identity_number')->unique();
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('occupation')->nullable();
            $table->enum('marital_status', ['single', 'married']);
            $table->enum('relation', ['wife', 'child', 'husband']);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
