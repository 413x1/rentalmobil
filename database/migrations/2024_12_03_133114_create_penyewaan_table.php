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
        Schema::create('penyewaan', function (Blueprint $table) {
            $table->id('penyewaan_id'); // Primary key untuk tabel penyewaan
            // Menambahkan foreign key untuk user_id, mobil_id, dan penyewa_id
            $table->foreignId('user_id')->constrained('user', 'user_id')->onDelete('cascade');
            $table->foreignId('mobil_id')->constrained('mobil', 'mobil_id')->onDelete('cascade');
            $table->foreignId('penyewa_id')->constrained('penyewa', 'penyewa_id')->onDelete('cascade');
            $table->date('sewa'); // Tanggal sewa
            $table->date('kembali'); // Tanggal kembali
            $table->decimal('harga', 15, 2); // Harga sewa
            $table->integer('lama_sewa')->nullable(); // Lama sewa dalam hari
            $table->decimal('total_denda', 15, 2)->nullable(0); // Total denda
            $table->decimal('total_harga', 15, 2)->default(0); // Total harga sewa, default 0
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewaan');
    }
};
