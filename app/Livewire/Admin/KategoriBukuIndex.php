<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class KategoriBukuIndex extends Component
{
    public $kategoriBuku;
    public $categoryName;
    public $showModal = false;

    public function mount()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->kategoriBuku = DB::table('kategori_buku')->get();
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->categoryName = '';
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function saveKategori()
    {
        $namaFormatted = ucwords(strtolower($this->categoryName));


        DB::table('kategori_buku')->insert([
            'nama' => $namaFormatted,
        ]);

        $this->refreshData();
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.kategori-buku-index');
    }
}
