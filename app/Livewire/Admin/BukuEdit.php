<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BukuEdit extends Component
{
    use WithFileUploads;

    public $bukuId;
    public $kategori;
    public $nama_buku, $penulis, $terbit_tahun, $penerbit;
    public $ringkasan, $foto_buku;
    public $kondisi, $catatan;
    public $list_kategori, $list_kondisi;
    public $newTag, $tags = [];
    public $tampil;
    public $fotoLama;
    public $position_foto = 'center'; // Tambahan posisi foto

    public function mount($id)
    {
        $this->bukuId = $id;
        $buku = DB::table('buku')->where('id', $id)->first();

        $this->list_kategori = DB::table('kategori_buku')->pluck('nama', 'id')->toArray();
        $this->list_kondisi = ['Baik', 'Rusak'];

        if ($buku) {
            $this->nama_buku = $buku->nama_buku;
            $this->penulis = $buku->penulis;
            $this->terbit_tahun = $buku->terbit_tahun;
            $this->penerbit = $buku->penerbit;
            $this->kategori = $buku->id_kategori_buku;
            $this->ringkasan = collect(preg_split('/<\/p>\s*/i', $buku->ringkasan))
                ->map(fn($p) => trim(strip_tags($p)))
                ->filter()
                ->implode("\n\n");
            $this->kondisi = $buku->kondisi;
            $this->catatan = $buku->catatan;
            $this->tampil = $buku->tampil;

            $this->tags = json_decode($buku->tags ?? '[]', true);
            $this->fotoLama = $buku->foto_buku;
            $this->position_foto = $buku->position_foto ?? 'center'; // Isi data posisi
        }
    }

    public function update()
    {
        $this->validate([
            'nama_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'terbit_tahun' => 'required|digits:4|integer|min:1000|max:' . date('Y'),
            'penerbit' => 'required|string|max:255',
            'ringkasan' => 'required|string',
            'kategori' => 'required|exists:kategori_buku,id',
            'kondisi' => 'required|string',
            'tampil' => 'required|in:ya,tidak',

            'catatan' => 'nullable|string',
            'tags' => 'nullable|array',
            'foto_buku' => $this->foto_buku ? 'image|mimes:jpg,png,jpeg,gif|max:2048' : '',
            'position_foto' => 'required|in:top,center,bottom', // Validasi posisi
        ]);

        $ringkasanHtml = collect(explode("\n", $this->ringkasan))
            ->map(fn($p) => '<p>' . e(trim($p)) . '</p>')
            ->implode('');

        $data = [
            'nama_buku' => $this->nama_buku, 
            'penulis' => $this->penulis,
            'terbit_tahun' => $this->terbit_tahun,
            'penerbit' => $this->penerbit,
            'id_kategori_buku' => $this->kategori,
            'ringkasan' => $ringkasanHtml,
            'kondisi' => $this->kondisi,
            'tampil' => $this->tampil,
            'catatan' => $this->catatan,
            'tags' => json_encode($this->tags),
            'position_foto' => $this->position_foto,
            'updated_at' => now(),
        ];

        if ($this->foto_buku instanceof \Illuminate\Http\UploadedFile) {
            if ($this->fotoLama && Storage::exists(str_replace('/storage/', 'public/', $this->fotoLama))) {
                Storage::delete(str_replace('/storage/', 'public/', $this->fotoLama));
            }

            $path = $this->foto_buku->store('images', 'public');
            $data['foto_buku'] = '/storage/' . $path;
        }

        DB::table('buku')->where('id', $this->bukuId)->update($data);

        session()->flash('message', 'Buku berhasil diperbarui!');
        return redirect()->to('/admin/buku');
    }

    public function addTag()
    {
        $tag = trim($this->newTag);
        if ($tag && !in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }
        $this->newTag = '';
    }

    public function removeTag($tag)
    { 
        $this->tags = array_filter($this->tags, fn($t) => $t !== $tag);
    }

    public function render()
    {
        return view('livewire.admin.buku-edit');
    }
}
