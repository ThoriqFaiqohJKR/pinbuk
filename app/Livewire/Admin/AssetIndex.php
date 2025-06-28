<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AssetIndex extends Component
{
    public $search;
    public $jenis_aset_id;
    public $dipinjam;
    public $stok;
    public $nomor_asset;
    public $kondisi;
    public $tanggal_beli;

    public function exportCsv()
    {
        $asets = DB::table('aset')
            ->leftJoin('jenis_aset', 'aset.jenis_aset_id', '=', 'jenis_aset.id')
            ->select('aset.*', 'jenis_aset.nama as jenis_aset_nama');

        if ($this->search) {
            $asets->where('aset.nama_aset', 'like', '%' . $this->search . '%');
        }
        if ($this->tanggal_beli) {
            $asets->where('aset.tanggal_pembelian', 'like', '%' . $this->tanggal_beli . '%');
        }
        if ($this->jenis_aset_id) {
            $asets->where('aset.jenis_aset_id', $this->jenis_aset_id);
        }
        if ($this->nomor_asset) {
            $asets->where('aset.nomor_asset', 'like', '%' . $this->nomor_asset . '%');
        }
        if ($this->stok) {
            $asets->where('aset.stok', $this->stok === 'In Stock' ? '>' : '=', 0);
        }
        if ($this->kondisi) {
            $asets->where('aset.kondisi', $this->kondisi);
        }
        if ($this->dipinjam) {
            $asets->where('aset.dipinjam', $this->dipinjam);
        }

        $results = $asets->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="asets.csv"',
        ];

        $callback = function () use ($results) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Nama Aset',
                'Nomor Asset',
                'Serial Number',
                'Stok',
                'Jenis Aset',
                'Harga Perolehan',
                'Kondisi',
                'Catatan'
            ]);

            foreach ($results as $asset) {
                fputcsv($file, [
                    $asset->nama_aset,
                    $asset->nomor_asset,
                    $asset->serial_number,
                    $asset->stok,
                    $asset->jenis_aset_nama,
                    $asset->harga_perolehan,
                    $asset->kondisi,
                    $asset->catatan
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function searchAsets()
    {
        $query = DB::table('aset')
            ->leftJoin('jenis_aset', 'aset.jenis_aset_id', '=', 'jenis_aset.id')
            ->select('aset.*', 'jenis_aset.nama as jenis_aset');


        if ($this->search) {
            $query->where('nama_aset', 'like', '%' . $this->search . '%');
        }

        if ($this->jenis_aset_id) {
            $query->where('jenis_aset_id', $this->jenis_aset_id);
        }

        if ($this->stok) {
            if ($this->stok == 'In Stock') {
                $query->where('stok', '>', 0);
            } elseif ($this->stok == 'Out of Stock') {
                $query->where('stok', '=', 0);
            }
        }

        if ($this->dipinjam) {
            $query->where('dipinjam', $this->dipinjam);
        }

        return $query->orderBy('updated_at', 'desc')->paginate(12);
    }

    private function getEnumValues(string $table, string $column): array
    {
        $columnInfo = DB::selectOne("SHOW COLUMNS FROM `$table` WHERE Field = ?", [$column]);

        if (!$columnInfo || !isset($columnInfo->Type)) {
            return [];
        }

        preg_match('/enum\((.*)\)/', $columnInfo->Type, $matches);

        return isset($matches[1])
            ? array_map(fn($val) => trim($val, "'"), explode(',', $matches[1]))
            : [];
    }

    public function render()
    {
        $asets = $this->searchAsets();

        $jenisAsetList = DB::table('jenis_aset')->pluck('nama', 'id')->toArray();
        $dapatDipinjamList = $this->getEnumValues('aset', 'dipinjam');

        return view('livewire.admin.asset-index', [
            'asets' => $asets,
            'jenisAsetList' => $jenisAsetList,
            'dapatDipinjamList' => $dapatDipinjamList,
        ]);
    }
}
