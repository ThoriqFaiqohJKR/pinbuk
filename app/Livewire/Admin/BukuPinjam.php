<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class BukuPinjam extends Component
{
    public $nama, $barang, $tanggal_pinjam, $tanggal_kembali;
    public $bukus = [];
    public $users = [];
    public $stokHabis = false;  // Tambahkan properti untuk menyimpan status stok habis

    protected $rules = [
        'nama' => 'required|string|max:255',
        'barang' => 'required|integer',
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
    ];

    public function mount($id)
    {
        $this->bukus = DB::table('buku')->get();


        $this->users = DB::table('pengguna')->where('level', 'user')->get();

        $book = DB::table('buku')->find($id);
        if ($book) {
            $this->barang = $book->id;
        }
    }

    public function store()
    {
        $this->validate();
    
        // Ambil detail buku berdasarkan ID barang
        $book = DB::table('buku')->find($this->barang);
    
        if (!$book) {
            session()->flash('message', 'Buku tidak ditemukan.');
            return;
        }
    
        if ($book->stok <= 0) {
            $this->stokHabis = true;  // Set status stok habis
            session()->flash('message', 'Stok buku habis. Peminjaman tidak bisa dilakukan.');
            return;
        }
    

        $kode_uniq = $book->kode_uniq;
    
        DB::table('peminjaman')->insert([
            'kode_uniq' => $kode_uniq,  
            'user_id' => $this->nama,   
            'barang' => $book->nama_buku, 
            'tanggal_pinjam' => $this->tanggal_pinjam,
            'tanggal_kembali' => $this->tanggal_kembali,
            'status' => 'Dipinjam',
            'created_at' => now(), 
            'updated_at' => now(),
        ]);
    
        // Kurangi stok buku
        DB::table('buku')->where('id', $this->barang)->decrement('stok', 1);
    
        session()->flash('message', 'Peminjaman berhasil ditambahkan. Stok buku telah diperbarui.');
        return redirect()->to('/admin/peminjaman');
    }
    
}
