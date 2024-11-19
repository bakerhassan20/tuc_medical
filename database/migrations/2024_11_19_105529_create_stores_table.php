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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Store name
            $table->text('description');     // Store description
            $table->integer('quantity');    // Quantity in store
            $table->string('location');     // Store location
            $table->date('date');           // Date when the store data was created/updated
            $table->text('notes')->nullable(); // Notes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
