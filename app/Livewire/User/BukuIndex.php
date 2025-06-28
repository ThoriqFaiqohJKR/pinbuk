<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class BukuIndex extends Component
{
    public $kategoriBuku = [];
    public $kategoriTerbuka = null;

    public $books = [];
    public $currentIndex = 0;       // ← properti carousel

    public function mount()
    {
        // data kategori
        $this->kategoriBuku = DB::table('kategori_buku')->get()->map(function ($kategori) {
            $kategori->buku = DB::table('buku')
                ->where('id_kategori_buku', $kategori->id)
                ->get();
            return $kategori;
        });

        // data carousel (tampil = "ya")
        $this->books = DB::table('buku')
            ->where('tampil', 'ya')
            ->select('foto_buku', 'nama_buku')
            ->take(3)
            ->get()
            ->toArray();
    }

    public function nextSlide()
    {
        $this->currentIndex = ($this->currentIndex + 1) % count($this->books);
    }

    public function goToSlide($index)
    {
        $this->currentIndex = $index;
    }

    public function toggleKategori($id)
    {
        $this->kategoriTerbuka = ($this->kategoriTerbuka === $id) ? null : $id;
    }

    public function render()
    {
        /* kirim $books juga ke blade */
        return view('livewire.user.buku-index', [
            'books' => $this->books,
        ]);
    }
}
