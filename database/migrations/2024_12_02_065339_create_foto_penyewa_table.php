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
        Schema::create('foto_penyewa', function (Blueprint $table) {
            $table->id('fotopenyewa_id'); 
            $table->unsignedBigInteger('penyewa_id'); 
            $table->string('foto'); 
            $table->timestamps(); 
            $table->foreign('penyewa_id')->references('penyewa_id')->on('penyewa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_penyewa');
    }
};
