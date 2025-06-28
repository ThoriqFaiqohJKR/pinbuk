<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PeminjamanEdit extends Component
{
    /* ---------- properti ---------- */
    public $id;
    public $nama_peminjam, $barang;
    public $tanggal_pinjam, $tanggal_kembali;
    public $status = '', $statusAwal;
    public $keperluan = '', $catatan = '';
    public $harga_sewa = 0, $invoice = '';
    public $kode_uniq;
    public $kondisi = '';               // ← ditambah

    /* ---------- mount ---------- */
    public function mount($id)
    {
        $p = DB::table('peminjaman')
            ->join('pengguna', 'peminjaman.user_id', '=', 'pengguna.id')
            ->leftJoin('buku', 'peminjaman.kode_uniq', '=', 'buku.kode_uniq')
            ->select(
                'pengguna.nama as nama_peminjam',
                'buku.nama_buku  as barang',
                'peminjaman.*'
            )
            ->where('peminjaman.id', $id)
            ->first();

        abort_if(is_null($p), 404);

        $this->id              = $id;
        $this->nama_peminjam   = $p->nama_peminjam;
        $this->barang          = $p->barang;
        $this->tanggal_pinjam  = $p->tanggal_pinjam;
        $this->tanggal_kembali = $p->tanggal_kembali ?? '9999-12-31';
        $this->kode_uniq       = $p->kode_uniq;
        $this->status          = $p->status;
        $this->statusAwal      = $p->status;
        $this->keperluan       = $p->keperluan;
        $this->catatan         = $p->catatan;
        $this->harga_sewa      = $p->harga_sewa;
        $this->invoice         = $p->invoice;
        $this->kondisi         = $p->kondisi;   // ← ambil kondisi (bisa null)
    }

    public function getReadonlyInputProperty()
    {
        return $this->status !== 'Silahkan di Ambil';
    }

    /* ---------- helper readonly ---------- */
    public function getReadonlyStatusProperty()
    {
        return in_array($this->statusAwal, ['Request', 'Kembali', 'Hilang']);
    }

    /* ---------- ketika status diubah ---------- */
    public function updatedStatus()
    {
        if ($this->status === 'Dipinjam') {
            $this->tanggal_pinjam  = now()->toDateString();
            $this->tanggal_kembali = now()->addDays(30)->toDateString();
        }

        if ($this->status === 'Kembali') {
            $this->tanggal_kembali = now()->toDateString();
        }
    }

    /* ---------- proses simpan ---------- */
    public function updateStatus()
    {
        /* ---------- validasi ---------- */
        $this->validate([
            'status'    => ['required', Rule::in(['Request', 'Silahkan di Ambil', 'Dipinjam', 'Kembali', 'Hilang'])],
            'keperluan' => 'nullable|string|max:255',
            'catatan'   => 'nullable|string|max:255',
            'harga_sewa' => 'nullable|numeric|min:0',
            'invoice'   => 'nullable|string|max:255',
            'kondisi'   => $this->status === 'Kembali'
                ? ['required', Rule::in(['baik', 'rusak', 'hilang'])]
                : 'nullable',
        ]);

        /* ---------- stok otomatis ---------- */
        if ($this->statusAwal === 'Dipinjam' && $this->status === 'Kembali') {
            DB::table('buku')
                ->where('kode_uniq', $this->kode_uniq)
                ->increment('stok', 1);
        }

        /* ---------- update tabel peminjaman ---------- */
        DB::table('peminjaman')->where('id', $this->id)->update([
            'status'          => $this->status,
            'tanggal_pinjam'  => $this->tanggal_pinjam,
            'tanggal_kembali' => $this->tanggal_kembali,
            'keperluan'       => $this->keperluan,
            'catatan'         => $this->catatan,
            'harga_sewa'      => $this->harga_sewa,
            'invoice'         => $this->invoice,
            'kondisi'         => $this->status === 'Kembali' ? $this->kondisi : null,
            'updated_at'      => now(),
        ]);

        /* ---------- sinkronkan kondisi barang ---------- */
        if ($this->status === 'Kembali' && $this->kondisi) {

            // kalau kode_uniq berawalan B- berarti Buku, A- berarti Aset
            if (str_starts_with($this->kode_uniq, 'B-')) {
                DB::table('buku')
                    ->where('kode_uniq', $this->kode_uniq)
                    ->update(['kondisi' => $this->kondisi]);
            } elseif (str_starts_with($this->kode_uniq, 'A-')) {
                DB::table('aset')
                    ->where('kode_uniq', $this->kode_uniq)
                    ->update(['kondisi' => $this->kondisi]);
            }
            // -- Atau, kalau ingin simpel cukup jalankan di kedua tabel, mana yang ada akan ter-update
            // DB::table('buku')->orWhere('aset')->update([...]);
        }

        session()->flash('message', 'Peminjaman & kondisi barang berhasil diperbarui!');
        return redirect('/admin/peminjaman');
    }

    public function render()
    {
        return view('livewire.admin.peminjaman-edit');
    }
}
