<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BukuIndex extends Component
{
    public $kategoriBuku = [];
    public $kategoriTerbuka = null;

    public $books = [];
    public $currentIndex = 0;       // ← properti carousel

    public function mount()
    {
        $this->kategoriBuku = DB::table('kategori_buku')
            ->get()
            ->map(function ($kategori) {

                // Ambil SATU entri per judul+ringkasan
                $kategori->buku = DB::table('buku')
                    ->selectRaw('
                        MIN(id)           AS id,
                        nama_buku,
                        ringkasan,
                           MIN(position_foto) AS position_foto,
                        MIN(foto_buku)    AS foto_buku,
                        SUM(stok)         AS total_stok
                    ')
                    ->where('id_kategori_buku', $kategori->id)
                    ->groupBy('nama_buku', 'ringkasan')
                    ->orderBy('nama_buku')
                    ->get();

                return $kategori;
            });

        // data carousel (tampil = "ya")
        $this->books = DB::table('buku')
            ->where('tampil', 'ya')
            ->select('id', 'foto_buku', 'nama_buku', 'ringkasan')
            ->take(3)
            ->get()
            ->map(function ($book) {
                $book->ringkasan = Str::limit($book->ringkasan, 150, '...');
                return $book;
            });
    }

    public function nextSlide()
    {
        $count = count($this->books);

        if ($count > 0) {
            $this->currentIndex = ($this->currentIndex + 1) % $count;
        } else {
            $this->currentIndex = 0; // default aman
        }
    }


    public function goToSlide($index)
    {
        $this->currentIndex = $index;
    }

    public function toggleKategori($id)
    {
        $this->kategoriTerbuka = ($this->kategoriTerbuka === $id) ? null : $id;
    }
    public $query = '';

    public function search()
    {
        return redirect()->to('/user/buku?search=' . urlencode($this->query));
    }

    public function render()
    {
        /* kirim $books juga ke blade */
        return view('livewire.user.buku-index', [
            'books' => $this->books,
        ]);
    }
}
