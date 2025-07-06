<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class KatalogBuku extends Component
{
    public $kategoriId;

    public function mount($kategoriId)
    {
        $this->kategoriId = $kategoriId;
    }

    public function render()
    {
        // Ambil nama kategori
        $kategori = DB::table('kategori_buku')->find($this->kategoriId);

        // Subquery: id terkecil untuk kombinasi nama_buku + ringkasan
        $sub = DB::table('buku')
            ->selectRaw('MIN(id) as min_id')
            ->where('id_kategori_buku', $this->kategoriId)
            ->groupBy('nama_buku', 'ringkasan');

        // Ambil data utama + jumlah stok dari semua entri dengan judul+ringkasan sama
        $buku = DB::table('buku as b')
            ->joinSub($sub, 't', 'b.id', '=', 't.min_id')
            ->leftJoin('buku as s', function ($join) {
                $join->on('s.nama_buku', '=', 'b.nama_buku')
                     ->on('s.ringkasan', '=', 'b.ringkasan');
            })
            ->select(
                'b.id',
                'b.nama_buku',
                'b.ringkasan',
                'b.foto_buku',
                'b.position_foto',
                DB::raw('SUM(s.stok) AS total_stok')
            )
            ->groupBy('b.id', 'b.nama_buku', 'b.ringkasan', 'b.foto_buku', 'b.position_foto')
            ->orderByDesc('b.id') // atau pakai created_at kalau mau
            ->get();

        return view('livewire.user.katalog-buku', [
            'buku' => $buku,
            'namaKategori' => $kategori->nama ?? 'Tidak Diketahui',
        ]);
    }
}
