<div class="bg-gray-100 min-h-screen px-4 sm:px-6 md:px-8 py-6">
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-md p-6 sm:p-8">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Form Pengisian Aset</h2>

        <form wire:submit.prevent="store" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Nama Aset</label>
                <input type="text" wire:model="nama_aset" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('nama_aset') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Serial Number</label>
                <input type="text" wire:model="serial_number" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('serial_number') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2" x-data="{ imagePreview: '' }" x-init="imagePreview = $refs.fileInput?.files[0] ? URL.createObjectURL($refs.fileInput.files[0]) : ''">
                <label class="block text-sm text-gray-600 mb-1">Foto Aset</label>
                <input x-ref="fileInput" wire:model="foto_aset" type="file" accept="image/*"
                    @change="imagePreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : ''"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('foto_aset') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror

                <template x-if="imagePreview">
                    <div class="mt-4">
                        <img :src="imagePreview" class="w-full max-w-sm rounded shadow-md mx-auto" alt="Preview" />
                    </div>
                </template>
            </div>

    <!-- Jenis Aset -->
<div>
    <label>Jenis Aset</label>
    <select wire:model.live="jenis_aset_id" class="w-full p-2 border rounded">
        <option value="">Pilih Jenis Aset</option>
        @foreach($listJenisAset as $id => $nama)
            <option value="{{ $id }}">{{ $nama }}</option>
        @endforeach
    </select>
</div>

<!-- Sub Kategori Aset (muncul hanya jika ada sub kategori) -->
@if($showSubKategori)
    <div>
        <label>Sub Kategori Aset</label>
        <select wire:model.live="sub_kategori_aset_id" class="w-full p-2 border rounded">
            <option value="">Pilih Sub Kategori</option>
            @foreach($listSubKategori as $id => $nama)
                <option value="{{ $id }}">{{ $nama }}</option>
            @endforeach
        </select>
    </div>
@endif

          
            <div>
                <label class="block text-sm text-gray-600 mb-1">Tanggal Pembelian</label>
                <input type="date" wire:model="tanggal_pembelian" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('tanggal_pembelian') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Harga Perolehan</label>
                <input type="number" wire:model="harga_perolehan" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('harga_perolehan') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Umur Ekonomis (tahun)</label>
                <input type="number" wire:model="umur_ekonomis" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('umur_ekonomis') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Nilai Residu</label>
                <input type="number" wire:model="nilai_residu" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('nilai_residu') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

       <div x-data="{
    tahun: @entangle('biaya_penyusutan_tahun'),
    bulan: @entangle('biaya_penyusutan_bulan'),
    hari: @entangle('biaya_penyusutan_hari'),
    displayTahun: '',
    displayBulan: '',
    displayHari: '',
    formatRupiah(val) {
        val = parseInt(val);
        if (!val && val !== 0) return '';
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    },
    parseRupiah(str) {
        return parseInt((str || '').replace(/\./g, '')) || 0;
    }
}"
x-init="
    displayTahun = formatRupiah(tahun);
    bulan = Math.round(tahun / 12);
    hari = Math.round(tahun / 365);
    displayBulan = formatRupiah(bulan);
    displayHari = formatRupiah(hari);
"
class="grid grid-cols-1 md:grid-cols-3 gap-6 md:col-span-2"
>

    <!-- Tahun -->
    <div>
        <label class="block text-sm text-gray-600 mb-1">Biaya Penyusutan / Tahun</label>
        <input type="text"
            x-model="displayTahun"
            @input="
                tahun = parseRupiah(displayTahun);
                displayTahun = formatRupiah(tahun);
                bulan = Math.round(tahun / 12);
                hari = Math.round(tahun / 365);
                displayBulan = formatRupiah(bulan);
                displayHari = formatRupiah(hari);
            "
            inputmode="numeric"
            class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none"
            placeholder="Masukkan angka"
        />
        @error('biaya_penyusutan_tahun') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Bulan -->
    <div>
        <label class="block text-sm text-gray-600 mb-1">Biaya Penyusutan / Bulan</label>
        <input type="text"
            x-model="displayBulan"
            readonly
            class="w-full p-2 border bg-gray-100 rounded-lg focus:outline-none"
        />
        @error('biaya_penyusutan_bulan') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Hari -->
    <div>
        <label class="block text-sm text-gray-600 mb-1">Biaya Penyusutan / Hari</label>
        <input type="text"
            x-model="displayHari"
            readonly
            class="w-full p-2 border bg-gray-100 rounded-lg focus:outline-none"
        />
        @error('biaya_penyusutan_hari') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>
</div>


            <div>
                <label class="block text-sm text-gray-600 mb-1">Akumulasi Penyusutan</label>
                <input type="number" wire:model="akumulasi_penyusutan" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('akumulasi_penyusutan') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Nilai Buku</label>
                <input type="number" wire:model="nilai_buku" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('nilai_buku') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Status Aset</label>
                <input type="text" wire:model="status_aset" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('status_aset') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Harga Sewa / Hari</label>
                <input type="number" wire:model="harga_sewa_per_hari" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('harga_sewa_per_hari') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Kondisi</label>
                <input type="text" wire:model="kondisi" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('kondisi') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg shadow-lg transition">
                    Simpan Aset
                </button>

                <a href="{{ url('/admin/asset/') }}"
                    class="mt-3 inline-block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-lg shadow transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
