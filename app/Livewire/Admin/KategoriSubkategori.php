<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class KategoriSubkategori extends Component
{
    public $kategoriId;
    public $subkategoriId;
    public $kategoriNama;
    public $subkategori1Nama;
    public $sub2 = [];
    public $buku = [];

    public function mount($kategoriId, $subkategoriId)
    {
        $this->kategoriId = $kategoriId;
        $this->subkategoriId = $subkategoriId;

        // Ambil nama kategori dan subkategori 1
        $this->kategoriNama = DB::table('kategori_buku')->where('id', $kategoriId)->value('nama');
        $this->subkategori1Nama = DB::table('sub_kategori_buku1')->where('id', $subkategoriId)->value('nama');

        // Ambil daftar subkategori 2
        $this->sub2 = DB::table('sub_kategori_buku2')
            ->where('id_sub_kategori1', $subkategoriId)
            ->get();

        // Ambil buku yang cocok
        $this->buku = DB::table('buku')
            ->where('id_kategori_buku', $kategoriId)
            ->where('sub_kategori1', $subkategoriId)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.kategori-subkategori');
    }
}
