<div class="container mx-auto px-6 lg:px-96 py-6">
    <div x-data="{ 
            imagePreview: '{{ $foto_buku ? asset('storage/' . $foto_buku) : ($fotoLama ? asset($fotoLama) : '') }}',
            dropdownKategoriOpen: false,
            dropdownSubkategori1Open: false,
            dropdownSubkategori2Open: false
        }"
        class="bg-white p-6 rounded-lg shadow-lg">

        <h2 class="text-2xl font-bold mb-4">Form Pengeditan Buku</h2>

        <form wire:submit.prevent="update" class="space-y-4">

            <!-- Nama Buku -->
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="namaBuku">Nama Buku</label>
                <input wire:model="nama_buku" id="namaBuku" type="text"
                    placeholder="Masukkan nama buku"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('nama_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <!-- Penulis -->
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="penulis">Penulis</label>
                <input wire:model="penulis" id="penulis" type="text"
                    placeholder="Nama penulis"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('penulis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Tahun Terbit -->
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="tahunTerbit">Tahun Terbit</label>
                <input wire:model="terbit_tahun" id="tahunTerbit" type="number" min="0"
                    placeholder="Contoh 2024"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('terbit_tahun') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Penerbit -->
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="penerbit">Penerbit</label>
                <input wire:model="penerbit" id="penerbit" type="text"
                    placeholder="Nama penerbit"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('penerbit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>


            <!-- Ringkasan -->
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="ringkasan">Ringkasan</label>
                <textarea wire:model="ringkasan" id="ringkasan" rows="4"
                    placeholder="Masukkan ringkasan buku"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                @error('ringkasan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>

            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="kategori">Kategori</label>
                <select wire:model="kategori" id="kategori" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Kategori</option>
                    @foreach ($list_kategori as $id =>$kategori)
                    <option value="{{ $id }}" {{ $id == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                    @endforeach
                </select>
                @error('kategori') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>




            <div class="mb-4">
                <label for="tags" class="block text-sm font-medium text-gray-700">Tags (1 kata per tag)</label>
                <div class="flex flex-wrap gap-2">
                    <div class="flex items-center">
                        <input wire:model="newTag" id="tags" type="text"
                            class="mt-1 block w-full px-3 py-2 border rounded-md"
                            placeholder="Masukkan tag" />
                        <button type="button" wire:click="addTag"
                            class="ml-2 bg-blue-500 text-white px-3 py-1 rounded-lg">Add</button>
                    </div>

                    <div class="flex gap-2 mt-2 flex-wrap">
                        @foreach($tags as $tag)
                        <span class="bg-blue-200 text-blue-800 px-3 py-1 rounded-full">
                            {{ $tag }}
                            <button type="button" wire:click="removeTag('{{ $tag }}')"
                                class="text-red-500 ml-2">x</button>
                        </span>
                        @endforeach
                    </div>
                </div>
                @error('tags') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>


            <!-- Foto Buku -->
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="photoBuku">Foto Buku</label>
                <input wire:model="foto_buku" type="file" id="photoBuku"
                    @change="imagePreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : imagePreview"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('foto_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Preview Foto -->
            <div x-show="imagePreview" class="mb-3">
                <img :src="imagePreview" alt="Preview Buku"
                    class="w-32 h-48 object-cover rounded-lg mx-auto shadow-md" />
            </div>



            <!-- Kondisi -->
            <div x-data="{ dropdownKondisiOpen: false, pilihKondisi(val) { @this.set('kondisi', val); this.dropdownKondisiOpen = false } }" class="relative">
                <label class="block text-gray-700 font-bold mb-1">Kondisi</label>
                <div @click="dropdownKondisiOpen = !dropdownKondisiOpen"
                    class="w-full px-3 py-2 border rounded-lg cursor-pointer flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span>{{ $kondisi ?: 'Pilih Kondisi' }}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div x-show="dropdownKondisiOpen" class="absolute z-10 bg-white w-full mt-1 rounded-lg shadow-lg">
                    @foreach(['Baik', 'Cukup', 'Rusak Ringan', 'Rusak Berat', 'Hilang'] as $kondisiItem)
                    <a href="#" @click.prevent="pilihKondisi('{{ $kondisiItem }}')" class="block px-4 py-2 hover:bg-gray-100">{{ $kondisiItem }}</a>
                    @endforeach
                </div>
                @error('kondisi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Posisi Gambar</label>
                <select wire:model="position_foto" class="w-full p-2 border rounded">
                    <option value="top">Atas</option>
                    <option value="center">Tengah</option>
                    <option value="bottom">Bawah</option>
                </select>
                @error('position_foto') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Tampilkan Buku di Katalog?</label>
                <select wire:model="tampil" class="w-full p-2 border rounded">
                    <option value="">Pilih</option>
                    <option value="ya">Ya</option>
                    <option value="tidak">Tidak</option>
                </select>
                @error('tampil') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>


            <!-- Catatan -->
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="catatan">Catatan</label>
                <textarea wire:model="catatan" id="catatan" rows="3"
                    placeholder="Tambahkan catatan tentang kondisi buku, lokasi, atau hal lainnya..."
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                @error('catatan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Button -->
            <div class="flex flex-col gap-3">
                <button type="submit"
                    class="bg-blue-500 text-white w-full py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Simpan Perubahan
                </button>
                <a href="{{ url('/admin/buku/') }}"
                    class="bg-gray-500 text-white w-full py-2 rounded-lg text-center hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>