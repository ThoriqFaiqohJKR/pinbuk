<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AssetPinjam extends Component
{
    public $user_id, $asset, $keperluan = 'Pribadi', $tanggal_pinjam, $tanggal_kembali, $catatan = '';
    public $assets = [];
    public $users = [];
    public $stokHabis = false;

    protected $rules = [
        'user_id' => 'required|integer',
        'asset' => 'required|integer',
        'keperluan' => 'required|in:Pribadi,Project',
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        'catatan' => 'nullable|string|max:255',
    ];

    public function mount($id)
    {
        $this->assets = DB::table('asset')->get();
        $this->users = DB::table('users')->where('role', 'user')->get();

        $asset = DB::table('asset')->find($id);
        if ($asset) {
            $this->asset = $asset->id;
        }
    }

    public function store()
    {
    
        $this->validate();

        if ($this->keperluan === 'Pribadi') {
            $this->tanggal_kembali = '9999-12-31';
        }

        $asset = DB::table('asset')->find($this->asset);

        if (!$asset) {
            session()->flash('message', 'Asset tidak ditemukan.');
            return;
        }

        if ($asset->stok <= 0) {
            $this->stokHabis = true;
            session()->flash('message', 'Stok asset habis. Peminjaman tidak bisa dilakukan.');
            return;
        }

        $kode_uniq = $asset->kode_uniq;

        DB::table('peminjaman')->insert([
            'kode_uniq' => $kode_uniq,
            'user_id' => $this->user_id,
            'barang' => $asset->nama_barang,
            'tanggal_pinjam' => $this->tanggal_pinjam,
            'tanggal_kembali' => $this->tanggal_kembali,
            'status' => 'Dipinjam',
            'keperluan' => $this->keperluan,
            'catatan' => $this->catatan ?? '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('asset')->where('id', $this->asset)->decrement('stok', 1);

        session()->flash('message', 'Peminjaman berhasil ditambahkan. Stok asset telah diperbarui.');
        return redirect()->to('/admin/peminjaman');
    }

    public function render()
    {
        return view('livewire.admin.asset-pinjam', [
            'assets' => $this->assets,
            'users' => $this->users,
        ]);
    }
}
