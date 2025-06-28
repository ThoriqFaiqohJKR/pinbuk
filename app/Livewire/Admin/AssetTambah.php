<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AssetTambah extends Component
{
    use WithFileUploads;

    /* ───────────── state/form ───────────── */
    // kolom tabel
    public $nama_aset,
        $serial_number,
        $foto_aset,
        $jenis_aset_id,
        $sub_kategori_aset_id,
        $tanggal_pembelian,
        $harga_perolehan,
        $umur_ekonomis,
        $nilai_residu,
        $akumulasi_penyusutan,
        $nilai_buku,
        $status_aset,
        $harga_sewa_per_hari,
        $kondisi;

    public $biaya_penyusutan_tahun = 0;
    public $biaya_penyusutan_bulan = 0;
    public $biaya_penyusutan_hari  = 0;

    // pelengkap
    public $kode_uniq;
    public $listJenisAset     = [];
    public $listSubKategori   = [];
    public $showSubKategori   = false;

    /* ───────────── rules ───────────── */
    protected $rules = [
        'nama_aset'              => 'required|string|max:255',
        'serial_number'          => 'nullable|string|max:255',
        'jenis_aset_id'          => 'required|exists:jenis_aset,id',
        'sub_kategori_aset_id'   => 'nullable|exists:sub_kategori_jenis_aset,id',
        'tanggal_pembelian'      => 'required|date',
        'harga_perolehan'        => 'required|numeric|min:0',
        'umur_ekonomis'          => 'required|integer|min:0',
        'nilai_residu'           => 'required|numeric|min:0',
        'biaya_penyusutan_tahun' => 'required|numeric|min:0',
        'biaya_penyusutan_bulan' => 'required|numeric|min:0',
        'biaya_penyusutan_hari'  => 'required|numeric|min:0',
        'akumulasi_penyusutan'   => 'required|numeric|min:0',
        'nilai_buku'             => 'required|numeric|min:0',
        'status_aset'            => 'required|string|max:255',
        'harga_sewa_per_hari'    => 'nullable|numeric|min:0',
        'kondisi'                => 'required|string|max:255',
        'foto_aset'              => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ];

    /* ───────────── mount ───────────── */
    public function mount()
    {
        $this->listJenisAset = DB::table('jenis_aset')->pluck('nama', 'id')->toArray();
    }

    /* ───────────── react ketika jenis_aset berganti ───────────── */
    public function updatedJenisAsetId($id)
    {
        $this->listSubKategori = DB::table('sub_kategori_jenis_aset')
            ->where('id_jenis_aset', $id)
            ->pluck('nama', 'id')
            ->toArray();

        $this->showSubKategori     = !empty($this->listSubKategori);
        $this->sub_kategori_aset_id = null;
    }

    /* ───────────── simpan ───────────── */
    public function store()
    {
        $data = $this->validate();

        /* upload foto */
        if ($this->foto_aset) {
            $path                = $this->foto_aset->store('images/aset', 'public');
            $data['foto_aset']   = '/storage/' . $path;
        }

        /* kode unik */
        $last = DB::table('aset')->latest('id')->value('kode_uniq');
        $seq  = $last ? ((int)substr($last, 2)) + 1 : 1;
        $this->kode_uniq = 'A-' . str_pad($seq, 5, '0', STR_PAD_LEFT);
        $data['kode_uniq'] = $this->kode_uniq;

        /* insert */
        $id = DB::table('aset')->insertGetId(array_merge($data, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        /* buat QR */
        $adminUrl = url('/admin/buku/' . $id . '/detail');
        $qrCodePath = 'public/qr_codes/buku/qr_' . $id . '.png';

        $qrContent = $adminUrl;
        QrCode::format('png')->size(200)->generate($qrContent, storage_path('app/' . $qrCodePath));

        DB::table('aset')->where('id', $id)->update([
            'qr_code' => '/storage/qr_codes/aset/qr_' . $id . '.png'
        ]);

        session()->flash('message', "Aset ditambahkan (Kode: {$this->kode_uniq})");
        return redirect()->to('/admin/aset');
    }

        public function updatedBiayaPenyusutanTahun($value)
    {
        // pastikan angka (bisa pakai floatval utk jaga-jaga)
        $tahun = floatval($value);

        // hitung dan simpan
        $this->biaya_penyusutan_bulan = $tahun / 12;
        $this->biaya_penyusutan_hari  = $tahun / 365;   
    }

    /* ───────────── view ───────────── */
    public function render()
    {
        return view('livewire.admin.asset-tambah', [
            'listJenisAset'   => $this->listJenisAset,
            'listSubKategori' => $this->listSubKategori,
        ]);
    }
}
