<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SearchResult extends Component
{
    public $keyword;

    public function mount($keyword)
    {
        $this->keyword = $keyword;
    }

   public function render()
    {
        $q = '%' . $this->keyword . '%';

        $results = DB::table('buku')
            ->leftJoin('kategori_buku', 'buku.id_kategori_buku', '=', 'kategori_buku.id')
            ->select('buku.*', 'kategori_buku.nama')
            ->where(function ($query) use ($q) {
                $query->where('buku.nama_buku', 'like', $q)
                    ->orWhere('buku.penulis', 'like', $q)
                    ->orWhere('buku.penerbit', 'like', $q)
                    ->orWhere('buku.tags', 'like', $q)
                    ->orWhere('kategori_buku.nama', 'like', $q);
            })
            ->get();

        return view('livewire.user.search-result', [
            'results' => $results,
        ]);
    }
}
