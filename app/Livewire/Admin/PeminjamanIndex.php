<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PeminjamanIndex extends Component
{
    public $search = '';
    public $status = '';
    public $kategori = '';
    public $date_from = '';
    public $date_to = '';
    public $keperluan = '';
    public $tanggal_kembali = '';

    public function render()
    {
        $peminjaman = DB::table('peminjaman')
            ->leftJoin('pengguna', 'peminjaman.user_id', '=', 'pengguna.id')
            ->leftJoin('buku', function ($join) {
                $join->on('peminjaman.kode_uniq', '=', 'buku.kode_uniq')
                    ->where('peminjaman.kode_uniq', 'like', 'B-%');
            })
            ->select(
                'peminjaman.*',
                'pengguna.nama as nama_peminjam',
                'buku.nama_buku as nama_barang', // Menggunakan nama_buku di sini
                'buku.foto_buku as image_url'
            )
            ->when($this->search, fn($query) =>
            $query->where('pengguna.nama', 'like', '%' . $this->search . '%'))
            ->when($this->kategori, function ($query) {
                if ($this->kategori == 'Buku') {
                    return $query->where('peminjaman.kode_uniq', 'like', 'B-%');
                }
            })
            ->when($this->date_from, fn($query) =>
            $query->where('peminjaman.tanggal_pinjam', '>=', $this->date_from))
            ->when($this->date_to, fn($query) =>
            $query->where('peminjaman.tanggal_kembali', '<=', $this->date_to))
            ->when($this->keperluan, fn($query) =>
            $query->where('peminjaman.keperluan', 'like', '%' . $this->keperluan . '%'))
            ->orderBy('peminjaman.updated_at', 'desc')
            ->get();


        

        return view('livewire.admin.peminjaman-index', compact('peminjaman'));
    }

    public function exportCsv()
    {
        $peminjaman = DB::table('peminjaman')
            ->leftJoin('pengguna', 'peminjaman.user_id', '=', 'pengguna.id')
            ->leftJoin('buku', function ($join) {
                $join->on('peminjaman.kode_uniq', '=', 'buku.kode_uniq')
                    ->where('peminjaman.kode_uniq', 'like', 'B-%');
            })
            ->select(
                'peminjaman.*',
                'pengguna.nama as nama_peminjam',
                'buku.nama_buku as nama_barang', // Menggunakan nama_buku di sini
                'buku.foto_buku as image_url'
            )
            ->when($this->search, fn($query) =>
            $query->where('pengguna.nama', 'like', '%' . $this->search . '%'))
            ->when($this->status, fn($query) =>
            $query->where('peminjaman.status', $this->status))
            ->when($this->kategori, function ($query) {
                if ($this->kategori == 'Buku') {
                    return $query->where('peminjaman.kode_uniq', 'like', 'B-%');
                }
            })
            ->when($this->date_from, fn($query) =>
            $query->where('peminjaman.tanggal_pinjam', '>=', $this->date_from))
            ->when($this->date_to, fn($query) =>
            $query->where('peminjaman.tanggal_kembali', '<=', $this->date_to))
            ->when($this->keperluan, fn($query) =>
            $query->where('peminjaman.keperluan', 'like', '%' . $this->keperluan . '%'))
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="peminjaman.csv"',
        ];

        $callback = function () use ($peminjaman) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Nama Peminjam', 'Kode Uniq', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status', 'Keperluan', 'Catatan', 'Kategori']);

            foreach ($peminjaman as $data) {
                $kategori = Str::startsWith($data->kode_uniq, 'B-') ? 'Buku' : '-';

                $tanggal_kembali = in_array($data->tanggal_kembali, ['9999-12-31', '12-31-9999'])
                    ? 'Lifetime'
                    : $data->tanggal_kembali;

                fputcsv($file, [
                    $data->nama_peminjam,
                    $data->kode_uniq,
                    $data->tanggal_pinjam,
                    $tanggal_kembali,
                    $data->status,
                    $data->keperluan,
                    $data->catatan ?? '-',
                    $kategori,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
