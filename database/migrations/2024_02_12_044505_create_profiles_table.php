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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nickname');
            $table->string('gender');
            $table->integer('age');
            $table->string('phone_number');
            $table->string('city');
            $table->string('country');
            $table->string('postal_code');
            $table->string('facebook_account'); //url - should be  
            $table->string('linkedin_account');
            $table->string('github_account');
            $table->string('twitter_account');
            $table->string('instagram_account');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
