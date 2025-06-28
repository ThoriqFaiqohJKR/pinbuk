<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PeminjamanIndex extends Component
{
    public $peminjamanList;
    public $jenis;

    public function mount()
    {
        $userId = session('user_id');

        if (!$userId) { 
            abort(403, 'Unauthorized.');
        }

        // Ambil data peminjaman dan hubungkan dengan tabel pengguna
        $this->peminjamanList = DB::table('peminjaman')
            ->join('pengguna', 'peminjaman.user_id', '=', 'pengguna.id')  // Join dengan tabel pengguna
            ->where('peminjaman.user_id', $userId)
              ->orderByDesc('peminjaman.tanggal_pinjam') 
            ->select('peminjaman.*', 'pengguna.nama as nama_peminjam')  // Ambil nama peminjam dari pengguna
            ->get();

        // Proses setiap peminjaman untuk menambahkan informasi buku
        foreach ($this->peminjamanList as $item) {
            // Tentukan jenis (Aset/Buku)
            $item->jenis = $this->getJenis($item->kode_uniq);

            // Ambil data buku hanya jika jenis adalah Buku
            if ($item->jenis === 'Buku') {
                $data = DB::table('buku')->where('kode_uniq', $item->kode_uniq)->first();
            

                if ($data) {
                    $item->nama = $data->nama_buku ?? 'Tidak ditemukan';
                    $item->gambar = $data->foto_buku ?? 'https://via.placeholder.com/60';
                } else { 
                    $item->nama = 'Tidak ditemukan';
                    $item->gambar = 'https://via.placeholder.com/60';
                }
            } else {
                $item->nama = 'Belum tersedia';
                $item->gambar = 'https://via.placeholder.com/60';
            }
        }
    }

    // Fungsi menentukan jenis berdasarkan prefix kode
    public function getJenis($kodeUniq)
    {
        // Cek jika kode dimulai dengan A- atau B-
        if (strpos($kodeUniq, 'A-') === 0) {
            return 'Aset';
        } elseif (strpos($kodeUniq, 'B-') === 0) {
            return 'Buku';
        }
        return 'Unknown'; // Jika kode tidak sesuai, kembalikan Unknown
    }

    // Render tampilan
    public function render()
    {
        return view('livewire.user.peminjaman-index', [
            'peminjamanList' => $this->peminjamanList
        ]);
    }
}
