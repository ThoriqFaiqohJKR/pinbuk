<div class="container mx-auto px-6 lg:px-96 py-6">
    <div x-data="{
            imagePreview: '',
            dropdownGenreOpen: false,
            dropdownLokasiOpen: false
        }"
        class="border border-gray-300 p-6 shadow-lg">

        <h2 class="text-2xl font-bold mb-4">Form Pengisian Buku</h2>

        {{-- Loading state --}}
        <div wire:loading wire:target="store" class="text-blue-500 text-sm mb-2">
            Menyimpan data...
        </div>

        <form wire:submit.prevent="store" class="space-y-4">

            {{-- Nama Buku --}}
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="namaBuku">Nama Buku</label>
                <input wire:model="nama_buku" id="namaBuku" type="text"
                    placeholder="Masukkan nama buku"
                    class="w-full px-3 py-2 border  -lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('nama_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Penulis --}}
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="penulis">Penulis</label>
                <input wire:model="penulis" id="penulis" type="text"
                    placeholder="Masukkan nama penulis"
                    class="w-full px-3 py-2 border  -lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('penulis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Tahun Terbit --}}
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="terbit_tahun">Tahun Terbit</label>
                <input wire:model="terbit_tahun" id="terbit_tahun" type="number"
                    placeholder="Contoh: 2022"
                    class="w-full px-3 py-2 border  -lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('terbit_tahun') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Penerbit --}}
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="penerbit">Penerbit</label>
                <input wire:model="penerbit" id="penerbit" type="text"
                    placeholder="Masukkan nama penerbit"
                    class="w-full px-3 py-2 border  -lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('penerbit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Ringkasan --}}
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="ringkasan">Ringkasan</label>
                <textarea wire:model="ringkasan" id="ringkasan" rows="4"
                    placeholder="Masukkan ringkasan buku"
                    class="w-full px-3 py-2 border  -lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                @error('ringkasan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label for="kategori" class="block text-gray-700 font-bold mb-1">Kategori</label>
                <select wire:model.lazy="kategori" id="kategori" class="w-full border   px-3 py-2">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($list_kategori as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
                @error('kategori') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Foto Buku --}}
            <div>
                <label class="block text-gray-700 font-bold mb-1" for="photoBuku">Foto Buku</label>
                <input
                    wire:model="foto_buku"
                    type="file"
                    id="photoBuku"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('foto_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Preview Livewire --}}
            @if ($foto_buku)
            <div class="mb-3 mt-3">
                <img src="{{ $foto_buku->temporaryUrl() }}"
                    alt="Preview Buku"
                    class="w-32 h-48 object-cover rounded-lg mx-auto shadow-md" />
            </div>
            @endif



            <div>
                <label class="block text-sm text-gray-600 mb-1">Posisi Gambar (Object Position)</label>
                <select wire:model="position_foto" class="w-full p-2 border rounded">
                    <option value="top">Atas</option>
                    <option value="center">Tengah</option>
                    <option value="bottom">Bawah</option>
                </select>
                @error('position_foto') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>



            {{-- Kondisi --}}
            <div>
                <label for="kondisi" class="block text-sm font-medium text-gray-700">Kondisi</label>
                <select wire:model="kondisi" id="kondisi" class="mt-1 block w-full px-3 py-2 border  -md">
                    <option value="">-- Pilih Kondisi --</option>
                    @foreach ($list_kondisi as $k)
                    <option value="{{ $k }}">{{ $k }}</option>
                    @endforeach
                </select>
                @error('kondisi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Catatan --}}
            <div>
                <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea wire:model="catatan" id="catatan" rows="4"
                    class="mt-1 block w-full px-3 py-2 border  -md"></textarea>
                @error('catatan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Tampil di Halaman User</label>
                <select wire:model="tampil"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none">
                    <option value="ya">Ya</option>
                    <option value="tidak">Tidak</option>
                </select>
                @error('tampil') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tags --}}
            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700">Tags (1 kata per tag)</label>
                <div class="flex flex-wrap gap-2">
                    <div class="flex items-center">
                        <input wire:model="newTag" id="tags" type="text"
                            class="mt-1 block w-full px-3 py-2 border  -md"
                            placeholder="Masukkan tag" />
                        <button type="button" wire:click="addTag"
                            class="ml-2 bg-blue-500 text-white px-3 py-1  -lg">Add</button>
                    </div>

                    <div class="flex gap-2 mt-2">
                        @foreach($tags as $tag)
                        <span class="bg-blue-200 text-blue-800 px-3 py-1  -full">{{ $tag }}
                            <button type="button" wire:click="removeTag('{{ $tag }}')"
                                class="text-red-500 ml-2">x</button>
                        </span>
                        @endforeach
                    </div>
                </div>
                @error('tags') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Submit & Kembali --}}
            <div class="flex flex-col gap-3">
                <button type="submit"
                    class="bg-blue-500 text-white w-full py-2  -lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Submit
                </button>
                <a href="{{ url('/admin/buku/') }}"
                    class="bg-gray-500 text-white w-full py-2  -lg text-center hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>