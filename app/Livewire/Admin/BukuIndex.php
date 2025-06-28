<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class BukuIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $kategori = '';
    public $lokasi = '';
    public $stok = '';

    public $kategoriList = [];
    public $lokasiList = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingKategori()
    {
        $this->resetPage();
    }

    public function updatingStok()
    {
        $this->resetPage();
    }

    public function updatingLokasi()
    {
        $this->resetPage();
    }

    // Fungsi untuk mencari buku berdasarkan parameter pencarian
    public function searchBooks()
    {
        $query = DB::table('buku')
            ->leftJoin('kategori_buku', 'buku.id_kategori_buku', '=', 'kategori_buku.id')
            ->leftJoin('sub_kategori_buku1', 'buku.sub_kategori1', '=', 'sub_kategori_buku1.id')
            ->leftJoin('sub_kategori_buku2', 'buku.sub_kategori2', '=', 'sub_kategori_buku2.id')
            ->select('buku.*', 'kategori_buku.nama as kategori', 'sub_kategori_buku1.nama as sub_kategori1', 'sub_kategori_buku2.nama as sub_kategori2');

        if ($this->search) {
            $query->where('buku.nama_buku', 'like', '%' . $this->search . '%');
        }
        if ($this->kategori) {
            $query->where('buku.id_kategori_buku', $this->kategori);
        }
        if ($this->lokasi) {
            $query->where('buku.lokasi', $this->lokasi);
        }
        if ($this->stok === 'ada') {
            $query->where('buku.stok', '>', 0);
        } elseif ($this->stok === 'habis') {
            $query->where('buku.stok', '=', 0);
        }

        return $query->orderBy('buku.updated_at', 'desc')->paginate(12);
    }

    // Fungsi untuk mengekspor data buku ke CSV
    public function exportCsv()
    {
        // Query untuk mengambil data buku dengan join kategori, subkategori1, dan subkategori2
        $query = DB::table('buku')
            ->leftJoin('kategori_buku', 'buku.id_kategori_buku', '=', 'kategori_buku.id')
            ->leftJoin('sub_kategori_buku1', 'buku.sub_kategori1', '=', 'sub_kategori_buku1.id')
            ->leftJoin('sub_kategori_buku2', 'buku.sub_kategori2', '=', 'sub_kategori_buku2.id')
            ->select(
                'buku.id',
                'buku.nama_buku',
                'buku.ringkasan',
                'buku.foto_buku',
                'buku.stok',
                'kategori_buku.nama as kategori',
                'sub_kategori_buku1.nama as sub_kategori1',
                'sub_kategori_buku2.nama as sub_kategori2',
                'buku.kondisi',
                'buku.catatan',
                'buku.tags',
                'buku.lokasi'
            );
    
        // Filter berdasarkan pencarian dan kategori jika ada
        if ($this->search) {
            $query->where('buku.nama_buku', 'like', '%' . $this->search . '%');
        }
        if ($this->kategori) {
            $query->where('buku.id_kategori_buku', $this->kategori);
        }
        if ($this->lokasi) {
            $query->where('buku.lokasi', $this->lokasi);
        }
        if ($this->stok === 'ada') {
            $query->where('buku.stok', '>', 0);
        } elseif ($this->stok === 'habis') {
            $query->where('buku.stok', '=', 0);
        }
    
        // Mendapatkan hasil query
        $bukus = $query->get();
    
        // Menyiapkan header untuk CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="buku-list.csv"',
        ];
    
        // Callback untuk menulis data ke file CSV
        $callback = function () use ($bukus) {
            $file = fopen('php://output', 'w');
            
            // Menulis header CSV
            fputcsv($file, [
                'ID', 
                'Nama Buku', 
                'Ringkasan', 
                'Foto Buku', 
                'Stok', 
                'Kategori', 
                'Sub Kategori 1', 
                'Sub Kategori 2', 
                'Kondisi', 
                'Catatan', 
                'Tags', 
                'Lokasi'
            ]);
    
            // Menulis data buku ke dalam file CSV
            foreach ($bukus as $buku) {
                fputcsv($file, [
                    $buku->id,
                    $buku->nama_buku,
                    $buku->ringkasan,
                    $buku->foto_buku,
                    $buku->stok,
                    $buku->kategori,
                    $buku->sub_kategori1,
                    $buku->sub_kategori2,
                    $buku->kondisi,
                    $buku->catatan,
                    implode(', ', json_decode($buku->tags, true)), // Mengubah tags menjadi string
                    $buku->lokasi,
                ]);
            }
    
            fclose($file);
        };
    
        // Mengirimkan response berupa CSV
        return response()->stream($callback, 200, $headers);
    }
    

    // Render function untuk menampilkan data buku dengan kategori dan lokasi
    public function render()
    {
        $bukus = $this->searchBooks();

        // Mengambil data kategori dan lokasi
        $this->kategoriList = DB::table('kategori_buku')->pluck('nama', 'id');
       
        return view('livewire.admin.buku-index', [
            'bukus' => $bukus,
            'kategoriList' => $this->kategoriList,
            'lokasiList' => $this->lokasiList,
        ]);
    }
}
