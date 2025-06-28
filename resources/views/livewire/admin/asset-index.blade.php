<div class="container mx-auto px-4 md:px-16 lg:px-32 xl:px-64 py-4">
    @if (session()->has('message'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 2000)"
        x-show="show"
        x-transition
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
        role="alert">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">{{ session('message') }}</span>
    </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Data Aset</h1>
        <div class="flex space-x-2">
            <a href="aset/create">
                <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    <i class="fas fa-plus mr-2"></i>Tambah
                </button>
            </a>
            <a>
                <button wire:click="exportCsv" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    <i class="fas fa-print mr-2"></i>Print
                </button>
            </a>
        </div>
    </div>
    <div class="flex flex-col md:flex-row justify-between mb-4 space-y-4 md:space-y-0 md:space-x-4">
        <input type="text" placeholder="Search asets..." class="px-4 py-2 border rounded-lg w-full md:w-1/3" wire:model.live.debounce.500ms="search">


     <select wire:model="jenis_aset_id" class="px-4 py-2 border rounded-lg w-full md:w-1/3">
    <option value="">Semua Jenis Aset</option>
    @foreach ($jenisAsetList as $id => $nama)
        <option value="{{ $id }}">{{ $nama }}</option>
    @endforeach
</select>


        <select wire:model.live.debounce.250ms="stok" class="px-4 py-2 border rounded-lg w-full md:w-1/3">
            <option value="">Filter Stok</option>
            <option value="In Stock">Tersedia</option>
            <option value="Out of Stock">Tidak Tersedia</option>
        </select>

        <select wire:model.live.debounce.250ms="dipinjam" class="px-4 py-2 border rounded-lg w-full md:w-1/3">
            <option value="">Pinjam Status</option>
            <option value="ya">Dapat Dipinjam</option>
            <option value="tidak">Tidak Dapat Dipinjam</option>
        </select>
    </div>

    <div class="grid grid-cols-2 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse ($asets as $aset)
        <a href="{{ url('/admin/aset/' . $aset->id. '/detail') }}" class="transform transition-transform hover:scale-105 cursor-pointer">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="{{ $aset->foto_aset }}" class="w-full h-48 object-cover rounded-md mb-4">
                <h2 class="text-md font-bold mb-2 break-words">{{ $aset->nama_aset }}</h2>
                <p class="text-gray-700 mb-2">Type: {{ $aset->jenis_aset }}</p>
                <p class="text-gray-700">
                    Stock:
                    @if ($aset->stok == 0)
                    <span class="bg-orange-100 text-orange-800 px-2.5 py-0.5 text-sm/6 font-semibold">Dipinjam</span>
                    @else
                    <span class="bg-blue-400 text-white px-2.5 py-0.5 text-sm font-semibold">Tersedia</span>
                    @endif
                </p>

            </div>
        </a>
        @empty
        <div class="col-span-full text-center text-gray-500">No asets found.</div>
        @endforelse

    </div>

    <div class="mt-6">
        {{ $asets->links() }}
    </div>
</div>