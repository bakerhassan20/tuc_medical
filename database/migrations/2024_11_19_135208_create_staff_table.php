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
        Schema::create('staff', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('engineer_id'); // Engineer ID
            $table->unsignedBigInteger('college_id'); // Foreign key to colleges table
            $table->unsignedBigInteger('department_id'); // Foreign key to departments table
            $table->date('date'); // Date column
            $table->string('img')->nullable(); // Image column, nullable as not all staff may have an image
            $table->timestamps();

            // Define foreign keys
            $table->foreign('engineer_id')->references('id')->on('engineers')->onDelete('cascade');
            $table->foreign('college_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
