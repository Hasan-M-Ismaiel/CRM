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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable();   // it not should be nullable if the add it as required in the form request
            // $table->date('deadline'); // this should be in the task 
            $table->string('status')->nullable(); // note remove the ->nullable after edit the create one task in the TaskController - this should not be nullable // this should be one of status: open - close - pending 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
