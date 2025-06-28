<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class BukuDetail extends Component
{
    public $peminjamanAktif = [];

    public $buku;
    public $confirmingDelete = false;
    public function confirmDelete()
    {
        $this->confirmingDelete = true;
    }

    public function deleteBuku()
    {
        DB::table('buku')->where('id', $this->buku->id)->delete();
        session()->flash('message', 'Buku berhasil dihapus.');
        return redirect('/admin/buku')->with('success', 'Buku berhasil dihapus.');
    }

    public function mount($id)
    {
        
        // Ambil data buku terlebih dahulu
        $this->buku = DB::table('buku')
            ->leftJoin('kategori_buku', 'buku.id_kategori_buku', '=', 'kategori_buku.id')
            ->leftJoin('sub_kategori_buku1', 'buku.sub_kategori1', '=', 'sub_kategori_buku1.id')
            ->leftJoin('sub_kategori_buku2', 'buku.sub_kategori2', '=', 'sub_kategori_buku2.id')
            ->select(
                'buku.*',
                'kategori_buku.nama as kategori_nama',
                'sub_kategori_buku1.nama as sub_kategori1_nama',
                'sub_kategori_buku2.nama as sub_kategori2_nama'
            )
            ->where('buku.id', $id)
            ->first();

        // Cek apakah data buku ditemukan
        if (!$this->buku) {
            return redirect()->route('admin.buku.index')->with('error', 'Buku tidak ditemukan.');
        }

        // Baru setelah buku tersedia, akses kode_uniq untuk mencari peminjaman
        $this->peminjamanAktif = DB::table('peminjaman')
            ->where('kode_uniq', 'like', $this->buku->kode_uniq . '%')
            ->where('status', '!=', 'Kembali')
            ->orderByDesc('created_at')
            ->get();
    }
    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'id_kategori_buku');
    }


    public function render()
    {
        return view('livewire.admin.buku-detail', [
            'buku' => $this->buku,
            'peminjamanAktif' => $this->peminjamanAktif,
        ]);
    }
}
