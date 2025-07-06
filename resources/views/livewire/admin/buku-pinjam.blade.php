<div class=" my-10">
    <div class="flex justify-center">
        <div class="max-w-3xl w-full bg-white p-8  shadow-xl border">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Form Peminjaman Buku</h1>

            <form wire:submit.prevent="store" class="space-y-6">
                <div x-data="{ open: false, selected: @entangle('nama') }" class="relative">
                    <label class="block text-sm font-medium text-gray-700">Nama</label>

                    <!-- Tombol dropdown -->
                    <button @click="open = !open"
                        class="mt-1 w-full px-4 py-2 border border-gray-300   bg-gray-50 text-left relative">

                        @php
                        $selectedUser = $users->firstWhere('id', $nama);
                        @endphp

                        @if($selectedUser)
                        {{ $selectedUser->nip }} - {{ $selectedUser->nama }}
                        <span class="absolute top-1/2 right-3 transform -translate-y-1/2">
                            <span class="inline-block w-3 h-3  
                    @if($selectedUser->status === 'hijau') bg-green-500
                    @elseif($selectedUser->status === 'kuning') bg-yellow-400
                    @elseif($selectedUser->status === 'merah') bg-red-500
                    @elseif($selectedUser->status === 'hitam') bg-black
                    @else bg-gray-300
                    @endif
                "></span>
                        </span>
                        @else
                        Pilih Nama
                        @endif
                    </button>

                    <!-- List dropdown -->
                    <ul x-show="open" @click.away="open = false"
                        class="absolute z-10 w-full mt-1 bg-white border   shadow-lg max-h-60 overflow-y-auto">

                        @foreach($users as $user)
                        <li
                            @if($user->status !== 'hitam')
                            @click="selected = '{{ $user->id }}'; $wire.set('nama', '{{ $user->id }}'); open = false"
                            @endif
                            class="px-4 py-2 flex justify-between items-center
                            {{ $user->status === 'hitam' ? 'text-gray-400 cursor-not-allowed' : 'hover:bg-gray-100 cursor-pointer' }}">

                            <span>{{ $user->nip }} - {{ $user->nama }}</span>
                            <span class="inline-block w-3 h-3 rounded-full 
                            @if($user->status === 'green') bg-green-500
                            @elseif($user->status === 'yellow') bg-yellow-400
                            @elseif($user->status === 'red') bg-red-500
                            @elseif($user->status === 'black') bg-black
                            @else bg-gray-300
                            @endif
                            "></span>
                        </li>

                        @endforeach

                    </ul>
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Buku</label>
                    <input type="text"
                        class="mt-1 w-full px-4 py-2 border border-gray-300   bg-gray-100 text-gray-600"
                        value="{{ $bukus->firstWhere('id', $barang)->nama_buku ?? 'Buku tidak ditemukan' }}"
                        readonly>
                </div>

                <div>
                    <label for="tanggalPinjam" class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                    <input type="date" wire:model="tanggal_pinjam" id="tanggalPinjam"
                        class="mt-1 w-full px-4 py-2 border border-gray-300   focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-800" required>
                    @error('tanggal_pinjam') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tanggalKembali" class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
                    <input type="date" wire:model="tanggal_kembali" id="tanggalKembali"
                        class="mt-1 w-full px-4 py-2 border border-gray-300   focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-800" required>
                    @error('tanggal_kembali') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <button type="submit"
                        class="w-full py-3 px-4 bg-indigo-600 text-white   shadow hover:bg-indigo-700 transition duration-200">
                        Submit
                    </button>
                </div>
                <div>
                    <a href="{{ url('/admin/buku/' . $barang . '/detail') }}"
                        class="block text-center w-full mt-3 py-3 px-4 bg-gray-200 text-gray-800   shadow hover:bg-gray-300 transition duration-200">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>