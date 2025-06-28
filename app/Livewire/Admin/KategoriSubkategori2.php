<?php

namespace App\Livewire\Admin;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class KategoriSubkategori2 extends Component
{    public $kategoriId;
    public $subkategori1Id;
    public $subkategori2Id;
    public $kategoriNama;
    public $sub1Nama;
    public $sub2Nama;
    public $buku = [];

    public function mount($kategoriId, $subkategori1Id, $subkategori2Id)
    {
        $this->kategoriId     = $kategoriId;
        $this->subkategori1Id = $subkategori1Id;
        $this->subkategori2Id = $subkategori2Id;

        // Ambil nama kategori, sub1, sub2
        $this->kategoriNama = DB::table('kategori_buku')->where('id', $kategoriId)->value('nama');
        $this->sub1Nama     = DB::table('sub_kategori_buku1')->where('id', $subkategori1Id)->value('nama');
        $this->sub2Nama     = DB::table('sub_kategori_buku2')->where('id', $subkategori2Id)->value('nama');

        // Ambil daftar buku untuk subkategori2
        $this->buku = DB::table('buku')
            ->where('id_kategori_buku', $kategoriId)
            ->where('sub_kategori1', $subkategori1Id)
            ->where('sub_kategori2', $subkategori2Id)
            ->get();
    }
    public function render()
    {
        return view('livewire.admin.kategori-subkategori2');
    }
}
