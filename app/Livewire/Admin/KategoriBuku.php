<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
class KategoriBuku extends Component
{
    public $kategoriList;

    public function mount()
    {
        $this->kategoriList = DB::table('kategori_buku')->get();
    }
    public function render()
    {
        return view('livewire.admin.kategori-buku');
    }
}
