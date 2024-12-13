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
        Schema::create('foto_mobil', function (Blueprint $table) {
            $table->id('fotomobil_id'); 
            $table->unsignedBigInteger('mobil_id'); 
            $table->string('foto'); 
            $table->timestamps(); 
            $table->foreign('mobil_id')->references('mobil_id')->on('mobil')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_mobil');
    }
};
