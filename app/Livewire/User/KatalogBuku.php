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
        $kategori = DB::table('kategori_buku')->find($this->kategoriId);

        $buku = DB::table('buku')
            ->where('id_kategori_buku', $this->kategoriId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.user.katalog-buku', [
              'buku' => $buku,
            'namaKategori' => $kategori->nama ?? 'Tidak Diketahui',
        ]);
    }
}
