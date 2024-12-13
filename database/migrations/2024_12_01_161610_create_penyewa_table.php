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
        Schema::create('penyewa', function (Blueprint $table) {
            $table->id('penyewa_id');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('telepon', 13);
            $table->string('alamat');
            $table->date('tanggal_lahir');
            $table->string('nomor_identitas')->unique();
            // $table->timestamp('tanggal_daftar')->useCurrent();
            $table->string('foto'); // Foto KTP penyewa
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewa');
    }
};
