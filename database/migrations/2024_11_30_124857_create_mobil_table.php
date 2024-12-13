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
        Schema::create('mobil', function (Blueprint $table) {
            $table->id('mobil_id'); 
            $table->unsignedBigInteger('merk_id'); //Foreign key ke tabel merk
            $table->unsignedBigInteger('user_id'); //Foreign key ke tabel user
            $table->string('nopolisi'); 
            $table->boolean('status'); 
            $table->string('jenis_mobil'); 
            $table->double('total_denda'); 
            $table->double('harga'); 
            $table->string('foto'); // Thumbnail image 
            $table->timestamps(); 
            $table->foreign('merk_id')->references('merk_id')->on('merk'); 
            $table->foreign('user_id')->references('user_id')->on('user'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};
