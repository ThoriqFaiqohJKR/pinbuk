<div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-40 xl:px-48 py-8">
    <h1 class="text-2xl font-semibold mb-6">Kategori Buku</h1>

    <!-- Tombol Tambah -->
    <div class="space-x-2 mb-6">
        <button wire:click="openModal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Tambah Kategori</button>
    </div>

    <!-- Daftar Kategori -->
    <h2 class="text-xl font-semibold mb-4">Daftar Kategori</h2>
    <div class="space-y-2 mb-6">
        @foreach($kategoriBuku as $kategori)
            <div class="flex flex-col md:flex-row md:items-center justify-between border p-4 rounded shadow-sm">
                <div class="flex-1">
                    <p class="text-sm text-gray-600"><span class="font-semibold">ID:</span> {{ $kategori->id }}</p>
                    <p class="text-sm text-gray-600"><span class="font-semibold">Kategori Buku:</span> {{ $kategori->nama }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-900">Tambah Kategori</h2>
                <form wire:submit.prevent="saveKategori" class="space-y-4">
                    <div>
                        <label for="category-name" class="block text-gray-700 font-medium mb-1">Nama Kategori</label>
                        <input wire:model="categoryName" type="text" id="category-name" class="w-full border border-gray-300 rounded px-3 py-2" required />
                    </div>
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 rounded bg-gray-300 text-gray-800">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
