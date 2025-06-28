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
        Schema::create('aset', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aset');
            $table->string('serial_number')->nullable()->unique();
            $table->string('foto_aset')->nullable();

            $table->foreignId('jenis_aset_id')->constrained('jenis_aset')->onDelete('restrict');
            $table->foreignId('sub_kategori_aset_id')->constrained('sub_kategori_jenis_aset')->onDelete('restrict');


            $table->date('tanggal_pembelian')->nullable();
            $table->decimal('harga_perolehan')->default(0);
            $table->integer('umur_ekonomis')->default(0);


            // Penyusutan
            $table->decimal('nilai_residu'           )->default(0);
            $table->decimal('biaya_penyusutan_tahun' )->default(0);
            $table->decimal('biaya_penyusutan_bulan')->default(0);
            $table->decimal('biaya_penyusutan_hari')->default(0);
            $table->decimal('akumulasi_penyusutan')->default(0);

            // Nilai aset
            $table->decimal('nilai_buku')->default(0);

            // Status dan kondisi
            $table->string('status_aset');
            $table->decimal('harga_sewa_per_hari')->nullable();
            $table->string('kondisi')->default('baik');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset');
    }
};
