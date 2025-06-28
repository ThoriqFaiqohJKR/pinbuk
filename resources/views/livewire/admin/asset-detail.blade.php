<div class="container mx-auto px-4 md:px-96 py-4">
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col items-center">
                <img alt="Detailed view of the asset with intricate design and vibrant colors"
                    class="rounded-lg shadow-md mb-4"
                    height="500"
                    src="{{ $asset->foto_barang }}"
                    width="375" />

                <div class="mt-4 flex space-x-4">
                    <button class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition duration-300">
                        <a target="_blank" onclick="window.open('{{ url('/storage/qr_codes/asset/qr_' . $asset->id. '.png') }}').print()">
                            Print QR
                        </a>
                    </button>

                    <button class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition duration-300
                        {{ $asset->stok <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $asset->stok <= 0 ? 'disabled' : '' }}>
                        <a href="{{ $asset->stok > 0 ? url('/admin/asset/' . $asset->id . '/pinjam') : '#' }}">
                            Borrow Asset
                        </a>
                    </button>
                </div>
            </div>

            <div>
                <h1 class="text-3xl font-bold mb-2 text-gray-800">
                    {{ $asset->nama_barang }}
                </h1>

                <p class="text-gray-600 mb-4">
                    Jenis Asset:
                    <span class="font-semibold">{{ $asset->jenis_barang }}</span>
                </p>
                <p class="text-gray-600 mb-4">
                    Nomor Asset:
                    <span class="font-semibold">{{ $asset->nomor_asset }}</span>
                </p>
                <p class="text-gray-600 mb-4">
                    Serial Number:
                    <span class="font-semibold">{{ $asset->serial_number }}</span>
                </p>
                <p class="text-gray-600 mb-4">
                    Stok:
                    <span class="font-semibold">{{ $asset->stok }}</span>
                </p>
                <p class="text-gray-600 mb-4">
                    Harga:
                    <span class="font-semibold">Rp. {{ number_format($asset->harga_barang, 0, ',', '.') }}</span>
                </p>
                <p class="text-gray-600 mb-4">
                    Kondisi :
                    <span class="font-semibold">{{ $asset->kondisi }}</span>
                </p>
                <p class="text-gray-600 mb-4">
                    Dapat dipinjam :
                    <span class="font-semibold">{{ $asset->dipinjam }}</span>
                </p>
                <p class="text-gray-600 mb-4">
                    Deskripsi:
                    <span class="block font-normal mt-1">{{ $asset->catatan ?? 'Tidak ada deskripsi.' }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="mt-6 flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-4">
        <a href="{{ url('/admin/asset/' . $asset->id . '/edit') }}"
            class="bg-blue-500 text-white w-full px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition duration-300 text-center">
            Edit
        </a>
        <button wire:click="$set('showDeleteModal', true)"
            class="bg-red-500 text-white w-full px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition duration-300">
            Delete
        </button>

        <a href="{{ url('/admin/asset') }}"
            class="bg-gray-500 text-white w-full px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 transition duration-300 text-center">
            Back
        </a>
    </div>
    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Konfirmasi Hapus</h2>
            <p class="text-gray-600 mb-6">Apakah kamu yakin ingin menghapus aset <strong>{{ $asset->nama_barang }}</strong>? Tindakan ini tidak bisa dibatalkan.</p>
            <div class="flex justify-end space-x-3">
                <button wire:click="$set('showDeleteModal', false)"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                    Batal
                </button>
                <button wire:click="deleteAsset({{ $asset->id }})"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
    @endif
</div>