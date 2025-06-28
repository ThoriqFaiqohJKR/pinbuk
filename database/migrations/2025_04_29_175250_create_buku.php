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
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('nama_buku');
            $table->text('ringkasan')->nullable();
            $table->string('foto_buku')->nullable();
            $table->foreignId('id_kategori_buku')->constrained('kategori_buku')->onDelete('cascade');
            $table->foreignId('sub_kategori1')->nullable()->constrained('sub_kategori_buku1')->onDelete('cascade');
            $table->foreignId('sub_kategori2')->nullable()->constrained('sub_kategori_buku2')->onDelete('cascade');
            $table->integer('stok')->default(0);
            $table->string('lokasi')->nullable(); 
            $table->string('qr_code')->nullable();
            $table->string('kondisi')->nullable();
            $table->string('catatan')->nullable();
            $table->string('kode_uniq')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
