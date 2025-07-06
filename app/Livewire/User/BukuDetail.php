<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BukuDetail extends Component
{
    use WithPagination;

    // ===== props =====
    public $id;          // id buku yang diklik
    public $buku;        // detail buku
    public $user_id;     // user login
    public $sudahDipinjam;

    // ===== form pinjam =====
    public $kode_uniq;
    public $tanggal_pinjam;
    public $tanggal_kembali;

    // =====================================================================
    // mount
    // =====================================================================
    public function mount($id)
    {
        // validasi user login
        $this->user_id = session('user_id');
        if (!$this->user_id) {
            abort(403, 'Unauthorized.');
        }

        // simpan id buku
        $this->id = $id;

        // ambil detail buku + kategori
        $this->buku = DB::table('buku')
            ->leftJoin('kategori_buku', 'buku.id_kategori_buku', '=', 'kategori_buku.id')
            ->where('buku.id', $id)
            ->selectRaw('
        buku.*,
        kategori_buku.nama AS nama_kategori,
        (
            SELECT SUM(stok)
            FROM buku b2
            WHERE b2.nama_buku = buku.nama_buku
              AND b2.ringkasan = buku.ringkasan
        ) AS total_stok
    ')
            ->first();


        // cek status pinjam user
        $this->sudahDipinjam = DB::table('peminjaman')
            ->where('user_id', $this->user_id)
            ->where('kode_uniq', $this->buku->kode_uniq)
            ->where('status', 'Dipinjam')
            ->exists();
    }

    // =====================================================================
    // query rekomendasi, dipanggil di render agar paginate berfungsi
    // =====================================================================
    protected function otherBooksQuery()
    {
        return DB::table('peminjaman')
            ->join('buku', 'peminjaman.kode_uniq', '=', 'buku.kode_uniq')
            ->selectRaw('
        MIN(buku.id) as id,
        buku.nama_buku,
        buku.ringkasan,
        MIN(buku.foto_buku) as foto_buku,
        SUM(buku.stok) as total_stok,
        COUNT(peminjaman.id) as total_pinjam
    ')
            ->where('buku.id', '!=', $this->id)
            ->where('buku.id_kategori_buku', $this->buku->id_kategori_buku)
            ->groupBy('buku.nama_buku', 'buku.ringkasan')
            ->orderByDesc('total_pinjam');
    }

    // =====================================================================
    // aksi pinjam
    // =====================================================================
    public function pinjamBuku()
    {
        // Hitung total pinjaman aktif user (request, dipinjam, silahkan diambil)
        $jumlahPinjaman = DB::table('peminjaman')
            ->where('user_id', $this->user_id)
            ->whereIn('status', ['request', 'Dipinjam', 'Silahkan Diambil'])
            ->count();

        if ($jumlahPinjaman >= 3) {
            session()->flash('error', 'Anda hanya bisa meminjam maksimal 3 buku dalam satu waktu.');
            return;
        }

        // Cek dobel pinjam
        $masihDipinjam = DB::table('peminjaman')
            ->where('user_id', $this->user_id)
            ->where('kode_uniq', $this->buku->kode_uniq)
            ->where('status', 'Dipinjam')
            ->exists();

        if ($masihDipinjam) {
            session()->flash('error', 'Anda masih meminjam buku ini.');
            return;
        }

        // Cek stok
        $buku = DB::table('buku')
            ->where('kode_uniq', $this->buku->kode_uniq)
            ->first();

        if (!$buku || $buku->stok < 1) {
            session()->flash('error', 'Stok buku tidak tersedia.');
            return;
        }

        // Insert ke peminjaman
        DB::table('peminjaman')->insert([
            'user_id'         => $this->user_id,
            'kode_uniq'       => $this->buku->kode_uniq,
            'tanggal_pinjam'  => now()->toDateString(),
            'tanggal_kembali' => now()->addDays(30)->toDateString(),
            'keperluan'       => ' ',
            'catatan'         => ' ',
            'harga_sewa'      => 0,
            'invoice'         => ' ',
            'status'          => 'request',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // Kurangi stok
        DB::table('buku')
            ->where('kode_uniq', $this->buku->kode_uniq)
            ->decrement('stok', 1);

        session()->flash('success', 'Permintaan peminjaman berhasil dikirim.');
        $this->sudahDipinjam = true;

        return redirect('/user/peminjaman');
    }



    // =====================================================================
    // render
    // =====================================================================
    public function render()
    {
        return view('livewire.user.buku-detail', [
            'otherBooks' => $this->otherBooksQuery()->paginate(10)   // 10 buku → 5 per baris × 2 baris
        ]);
    }
}
