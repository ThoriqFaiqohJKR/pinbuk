<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PeminjamanDetail extends Component
{
    public $peminjamanId;
    public $peminjaman;

    public function mount($id)
    {
        $this->peminjamanId = $id;

        $this->peminjaman = DB::table('peminjaman')
            ->leftJoin('pengguna', 'peminjaman.user_id', '=', 'pengguna.id')
            ->leftJoin('buku', function ($join) {
                $join->on('peminjaman.kode_uniq', '=', 'buku.kode_uniq')
                    ->where('peminjaman.kode_uniq', 'like', 'B-%');
            })
            ->select(
                'peminjaman.*',
                'pengguna.nama as nama_peminjam',
                'buku.nama_buku as nama_barang',
                'buku.foto_buku as image_url'
            )
            ->where('peminjaman.id', $id)
            ->first();

        if (!$this->peminjaman) {
            abort(404, 'Data peminjaman tidak ditemukan');
        }
    }
    public function getJumlahHariProperty()
    {
        if (!$this->peminjaman->tanggal_kembali) {
            return null;
        }

        $tanggalPinjam = \Carbon\Carbon::parse($this->peminjaman->tanggal_pinjam);
        $tanggalKembali = \Carbon\Carbon::parse($this->peminjaman->tanggal_kembali);

        if ($tanggalKembali < $tanggalPinjam) {
            return null; // atau bisa return 0 atau kasih warning
        }

        return $tanggalPinjam->diffInDays($tanggalKembali);
    }


    public function render()
    {
        return view('livewire.admin.peminjaman-detail');
    }
}
