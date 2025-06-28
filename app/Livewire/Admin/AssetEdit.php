<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AssetEdit extends Component
{
    use WithFileUploads;

    public $assetId;
    public $nama_barang;
    public $tanggal_beli;
    public $foto_barang;
    public $foto_lama;
    public $harga_barang;
    public $jenis_barang;
    public $nomor_asset;
    public $stok;
    public $serial_number;
    public $qr_code;
    public $kode_uniq;
    public $dipinjam;
    public $kondisi;
    public $catatan;


    protected $rules = [
        'nama_barang' => 'required|string|max:255',
        'tanggal_beli' => 'required|date',
        'harga_barang' => 'required|integer',
        'jenis_barang' => 'required|string|max:255',
        'nomor_asset' => 'required|string|max:255',
        'stok' => 'required|integer',
        'serial_number' => 'required|string|max:255',
        'qr_code' => 'nullable|string|max:255',
        'kode_uniq' => 'required|string|max:255',
        'foto_barang' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        'dipinjam' => 'required|in:ya,tidak',
        'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
        'catatan' => 'nullable|string',

    ];

    public function mount($assetId)
    {
        $asset = DB::table('aset')->where('id', $assetId)->first();

        if ($asset) {
            $this->assetId = $asset->id;
            $this->nama_barang = $asset->nama_barang;
            $this->tanggal_beli = $asset->tanggal_beli;
            $this->harga_barang = $asset->harga_barang;
            $this->jenis_barang = $asset->jenis_barang;
            $this->nomor_asset = $asset->nomor_asset;
            $this->stok = $asset->stok;
            $this->serial_number = $asset->serial_number;
            $this->qr_code = $asset->qr_code;
            $this->kode_uniq = $asset->kode_uniq;
            $this->foto_lama = $asset->foto_barang;
            $this->dipinjam = $asset->dipinjam;
            $this->kondisi = $asset->kondisi;
            $this->catatan = $asset->catatan;
        }
    }

    public function update()
    {
        $this->validate();

        $fotoAsset = $this->foto_lama; // Default tetap foto lama

        if ($this->foto_barang) {
            // Hapus foto lama kalau ada
            if ($this->foto_lama) {
                Storage::delete(str_replace('/storage/', 'public/', $this->foto_lama));
            }

            // Simpan foto baru
            $fotoPath = $this->foto_barang->store('images/asset', 'public');
            $fotoAsset = '/storage/' . $fotoPath;
        }

        DB::table('aset')->where('id', $this->assetId)->update([
            'nama_barang' => $this->nama_barang,
            'tanggal_beli' => $this->tanggal_beli,
            'harga_barang' => $this->harga_barang,
            'jenis_barang' => $this->jenis_barang,
            'nomor_asset' => $this->nomor_asset,
            'stok' => $this->stok,
            'serial_number' => $this->serial_number,
            'qr_code' => $this->qr_code,
            'kode_uniq' => $this->kode_uniq,
            'dipinjam' => $this->dipinjam,
            'kondisi' => $this->kondisi,
            'catatan' => $this->catatan,
            'foto_barang' => $fotoAsset,
            'updated_at' => now(),
        ]);

        session()->flash('message', 'Asset berhasil diperbarui!');
        return redirect()->to('/admin/asset');
    }

    public function render()
    {
        return view('livewire.admin.asset-edit');
    }
}
