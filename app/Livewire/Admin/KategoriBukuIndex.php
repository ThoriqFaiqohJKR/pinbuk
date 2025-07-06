<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class KategoriBukuIndex extends Component
{
    public $kategoriBuku;
    public $categoryName;
    public $showModal = false;
    public $isEdit = false;
    public $categoryId;

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
        $this->reset(['categoryName', 'categoryId', 'isEdit']);
        $this->showModal = true;
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

    public function editKategori($id)
    {
        $kategori = DB::table('kategori_buku')->find($id);

        if ($kategori) {
            $this->categoryId = $kategori->id;
            $this->categoryName = $kategori->nama;
            $this->isEdit = true;
            $this->showModal = true;
        }
    }

    public function updateKategori()
    {
        $this->validate([
            'categoryName' => 'required|string|max:255',
        ]);

        $namaFormatted = ucwords(strtolower($this->categoryName));

        DB::table('kategori_buku')->where('id', $this->categoryId)->update([
            'nama' => $namaFormatted,
        ]);

        $this->refreshData();
        $this->closeModal();
    }


    public function render()
    {
        return view('livewire.admin.kategori-buku-index', [
            'kategoriBuku' => $this->kategoriBuku
        ]);
    }
}
