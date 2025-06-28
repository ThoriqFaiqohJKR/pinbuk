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
       Schema::table('buku', function (Blueprint $table) {
            // Tambahkan kolom baru
            $table->string('penulis')->nullable()->after('nama_buku');
            $table->year('terbit_tahun')->nullable()->after('penulis');
            $table->string('penerbit')->nullable()->after('terbit_tahun');

            // Hapus kolom lokasi
            $table->dropColumn('lokasi');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('buku', function (Blueprint $table) {
            // Rollback: tambahkan kolom lokasi kembali
            $table->string('lokasi')->nullable()->after('stok');

            // Hapus kolom yang ditambahkan
            $table->dropColumn(['penulis', 'terbit_tahun', 'penerbit']);
        });
    }
};
