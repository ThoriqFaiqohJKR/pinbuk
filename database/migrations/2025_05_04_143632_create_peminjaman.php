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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
             // Relasi ke tabel pengguna
             $table->foreignId('user_id')->constrained('pengguna')->onDelete('cascade');

             $table->string('kode_uniq')->unique();
             $table->date('tanggal_pinjam');
             $table->date('tanggal_kembali')->nullable();
             $table->string('keperluan')->nullable();
             $table->text('catatan')->nullable();
             $table->decimal('harga_sewa', 12, 2)->nullable(); // Bisa kosong
             $table->string('invoice')->nullable(); // Optional
             $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
