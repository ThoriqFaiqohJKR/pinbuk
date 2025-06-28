<div class="bg-gray-100 pt-6 md:pt-20 px-4 overflow-x-hidden">
    <div class="bg-white shadow-lg overflow-hidden w-full sm:w-[36rem] mx-auto mb-2">

        {{-- Header --}}
        @if ($user->level === 'user')
        @php
        $statusColor = match(strtolower($user->status)) {
        'green' => 'bg-green-500',
        'yellow' => 'bg-yellow-500',
        'red' => 'bg-red-600',
        'black' => 'bg-black',
        };
        @endphp

        <div class="{{ $statusColor }} text-center py-2">

            @else
            <div class="bg-blue-600 text-center py-2">
                @endif
                <h1 class="text-xl font-bold text-white">
                    KARTU {{ $user->level === 'admin' ? 'ADMIN' : 'ANGGOTA' }} AURIGA
                </h1>
            </div>

            {{-- Middle --}}
            <div class="{{ $user->level === 'admin' ? 'bg-slate-100' : 'bg-slate-50' }} p-6 flex flex-col md:flex-row">
                <div class="flex flex-col items-center md:items-start">
                    <img src="{{ asset('storage/' . $user->foto) }}"
                        alt="Foto Anggota"
                        class="w-40 h-48 object-cover shadow-md" />
                </div>

                <div class="flex-1 ml-0 md:ml-6 mt-4 md:mt-0">
                    <h2 class="text-xl font-bold text-blue-900">{{ $user->nama }}</h2>

                    @if ($user->level === 'admin')
                    <div class="mt-2 text-sm text-gray-700">
                        <p class="font-semibold">Nama : {{ $user->nama }}</p>
                        <p class="font-semibold">Email : {{ $user->email }}</p>
                        <p class="font-semibold">No no_no_tlpn : {{ $user->no_tlpn }}</p>
                        <p class="font-semibold">Password : {{ $user->password_plaintext ?? 'Tidak tersedia' }}</p>
                    </div>
                    @else
                    <p class="text-lg font-bold text-black mt-1">NIP : <span class="font-normal">{{ $user->nip }}</span></p>
                    <div class="mt-2 grid grid-cols-[auto_1fr] gap-x-2 gap-y-1 text-sm text-gray-700">
                        <p class="font-semibold">Jabatan</p>
                        <p>: {{ $user->jabatan ?? '-' }}</p>
                        <p class="font-semibold">Email</p>
                        <p>: {{ $user->email ?? '-' }}</p>
                        <p class="font-semibold">No. HP</p>
                        <p>: {{ $user->no_tlpn ?? '-' }}</p>
                        <p class="font-semibold">Status</p>
                        <p>: {{ strtoupper($user->status ?? '-') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Footer --}}
            @if ($user->level === 'user')
            @php
        $statusColor = match(strtolower($user->status)) {
        'green' => 'bg-green-500',
        'yellow' => 'bg-yellow-500',
        'red' => 'bg-red-600',
        'black' => 'bg-black',
        };
        @endphp

        <div class="{{ $statusColor }} text-center py-2">
            @else
            <div class="bg-blue-100 h-4"></div>
            @endif
        </div>

        {{-- Tombol Aksi --}}
        <div class="text-center w-full sm:w-[36rem] mx-auto flex flex-col sm:flex-row justify-between gap-2 mt-3">
            <a href="{{ url('/admin/users/' . $user->id . '/edit') }}"
                class="bg-white border border-gray-300 py-2 px-4 shadow-sm hover:bg-gray-100 w-full sm:w-[32%] text-center">
                <i class="fas fa-edit"></i> Edit
            </a>

            <button wire:click="confirmDelete"
                class="bg-white border border-gray-300 py-2 px-4 shadow-sm hover:bg-gray-100 w-full sm:w-[32%] text-center">
                <i class="fas fa-trash"></i> Delete
            </button>

            <a href="{{ url('/admin/users') }}"
                class="bg-white border border-gray-300 py-2 px-4 shadow-sm hover:bg-gray-100 w-full sm:w-[32%] text-center">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- Modal Delete --}}
        @if ($confirmingDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 shadow-lg w-full max-w-sm">
                <h2 class="text-lg font-bold mb-4">Hapus User?</h2>
                <p class="mb-4">Apakah kamu yakin ingin menghapus user ini?</p>
                <div class="flex justify-end space-x-2">
                    <button wire:click="cancelDelete"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-4 ">
                        Batal
                    </button>
                    <button wire:click="deleteUser"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>