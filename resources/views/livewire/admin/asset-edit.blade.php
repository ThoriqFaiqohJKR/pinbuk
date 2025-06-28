<div class="bg-gray-100 min-h-screen px-4 sm:px-6 md:px-8 py-6">
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-md p-6 sm:p-8">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Form Pengisian Aset</h2>

        <form wire:submit.prevent="update" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm text-gray-600 mb-1">Nomor Asset</label>
                <input type="text" wire:model="nomor_asset" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('nomor_asset') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>


            <div>
                <label class="block text-sm text-gray-600 mb-1">Nama Barang</label>
                <input type="text" wire:model="nama_barang" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('nama_barang') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>


            <div>
                <label class="block text-sm text-gray-600 mb-1">Serial Number</label>
                <input type="text" wire:model="serial_number" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('serial_number') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Tanggal Beli</label>
                <input type="date" wire:model="tanggal_beli" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('tanggal_beli') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>


            <div>
                <label class="block text-sm text-gray-600 mb-1">Harga Barang</label>
                <input type="number" wire:model="harga_barang" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('harga_barang') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>


            <div>
                <label class="block text-sm text-gray-600 mb-1">Stok</label>
                <input type="number" wire:model="stok" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('stok') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>


            <div class="md:col-span-2">
                <label class="block text-sm text-gray-600 mb-1">Jenis Barang</label>
                <select wire:model="jenis_barang" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none">
                    <option value="">Pilih Jenis Barang</option>
                    <option value="building">Building</option>
                    <option value="kendaraan">Kendaraan</option>
                    <optgroup label="Peralatan">
                        <option value="peralatan mebel">Peralatan Mebel</option>
                        <option value="peralatan non elektronik">Peralatan Non Elektronik</option>
                        <option value="peralatan elektronik">Peralatan Elektronik</option>
                        <option value="peralatan drone">Peralatan Drone</option>
                        <option value="peralatan multimedia">Peralatan Multimedia</option>
                    </optgroup>
                    <optgroup label="Lain-lain">
                        <option value="software">Software</option>
                        <option value="perlengkapan">Perlengkapan</option>
                    </optgroup>
                </select>
                @error('jenis_barang') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>


            <div class="md:col-span-2">
                <label class="block text-sm text-gray-600 mb-1">Foto Barang</label>
                <input wire:model="foto_barang" type="file" accept="image/*"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none" />
                @error('foto_barang') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror

                @if ($foto_barang)
                <div class="mt-4 text-center">
                    <img src="{{ $foto_barang->temporaryUrl() }}" class="w-40 h-60 object-cover rounded-lg mx-auto shadow" alt="Preview Gambar Baru">
                    <p class="text-xs text-gray-500 mt-2">Preview gambar baru</p>
                </div>
                @elseif ($foto_lama)
                <div class="mt-4 text-center">
                <img src="{{ asset($foto_lama) }}" class="w-full max-w-sm rounded shadow-md mx-auto" alt="Foto Lama" />
                    <p class="text-xs text-gray-500 mt-2">Foto sebelumnya</p>
                </div>
                @endif
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Dipinjam</label>
                <select wire:model="dipinjam" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none">
                    <option value="">Pilih Status</option>
                    <option value="ya">Ya</option>
                    <option value="tidak">Tidak</option>
                </select>
                @error('dipinjam') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Kondisi Barang</label>
                <select wire:model="kondisi" class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none">
                    <option value="">Pilih Kondisi</option>
                    <option value="baik">Baik</option>
                    <option value="rusak ringan">Rusak Ringan</option>
                    <option value="rusak berat">Rusak Berat</option>
                </select>
                @error('kondisi') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>


            <div class="md:col-span-2">
                <label class="block text-sm text-gray-600 mb-1">Catatan</label>
                <textarea wire:model="catatan" rows="3" placeholder="Catatan tambahan jika ada..."
                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none"></textarea>
                @error('catatan') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg shadow-lg transition">
                    Simpan Aset
                </button>
            </div>
        </form>
    </div>
</div>