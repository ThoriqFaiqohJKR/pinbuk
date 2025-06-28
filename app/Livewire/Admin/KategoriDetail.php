<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class KategoriDetail extends Component
{
    public $kategoriId;
    public $kategoriNama;
    public $sub1, $sub2, $buku;

    public function mount($kategoriId)
    {
        // Fetch the category (with error handling)
        $kategori = DB::table('kategori_buku')->find($kategoriId);
        if ($kategori) {
            $this->kategoriId = $kategoriId;
            $this->kategoriNama = $kategori->nama;
        } else {
            $this->kategoriNama = 'Kategori Tidak Ditemukan';
            return;  // If category not found, stop further execution.
        }

        // Fetch subcategory level 1
        $this->sub1 = DB::table('sub_kategori_buku1')->where('id_kategori', $kategoriId)->get();
    
        // If there are subcategories, fetch the second level
        if ($this->sub1->isNotEmpty()) {
            $sub1Ids = $this->sub1->pluck('id');
            $this->sub2 = DB::table('sub_kategori_buku2')
                ->whereIn('id_sub_kategori1', $sub1Ids)
                ->get();
        }

        // Fetch books for this category
        $this->buku = DB::table('buku')->where('id_kategori_buku', $kategoriId)->get();
    }
    
    public function render()
    {
        return view('livewire.admin.kategori-detail');
    }
}
