<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-xl border border-gray-200 mt-10">
    <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Peminjaman Asset</h2>
    <form wire:submit.prevent="store">
        <div class="space-y-6">
            <div class="mb-6">
                <label for="user_id" class="block text-gray-700 font-medium">Nama Peminjam</label>
                <select wire:model="user_id" id="user_id"
                    class="w-full p-4 mt-2 border rounded-lg bg-gray-100 text-gray-700" required>
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->nip }} - {{ $user->name }}</option> <!-- NIP - NAMA USER -->
                        @endforeach
                </select>
                @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mb-6">
                <label for="asset" class="block text-gray-700 font-medium">Nama Asset</label>
                <input type="text" class="w-full p-4 mt-2 border rounded-lg bg-gray-100 text-gray-700"
                    value="{{ $assets->firstWhere('id', $asset)->nama_barang ?? 'Asset tidak ditemukan' }}"
                    readonly>
            </div>


            <div class="mb-6">
                <label for="keperluan" class="block text-gray-700 font-medium">Keperluan Peminjaman</label>
                <select wire:model="keperluan" id="keperluan" class="w-full p-4 mt-2 border rounded-lg bg-gray-100 text-gray-700" required>
                    <option value="Pribadi">Pribadi</option>
                    <option value="Project">Project</option>
                </select>
                @error('keperluan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>


            <div class="mb-6">
                <label for="tanggal_pinjam" class="block text-gray-700 font-medium">Tanggal Pinjam</label>
                <input type="date" wire:model="tanggal_pinjam" id="tanggal_pinjam" class="w-full p-4 mt-2 border rounded-lg bg-gray-100 text-gray-700" required>
                @error('tanggal_pinjam') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6" x-data>
                <label for="tanggal_kembali" class="block text-gray-700 font-medium">Tanggal Kembali</label>

                <template x-if="$wire.keperluan === 'Project'">
                    <input type="date" wire:model="tanggal_kembali" id="tanggal_kembali"
                        class="w-full p-4 mt-2 border rounded-lg bg-gray-100 text-gray-700" required>
                </template>

                <template x-if="$wire.keperluan === 'Pribadi'">
                    <input type="hidden" wire:model="tanggal_kembali" value="9999-12-31">
                </template>

                @error('tanggal_kembali') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="catatan" class="block text-gray-700 font-medium">Catatan Keperluan Peminjaman</label>
                <textarea wire:model="catatan" id="catatan" class="w-full p-4 mt-2 border rounded-lg bg-gray-100 text-gray-700" rows="4"></textarea>
                @error('catatan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Simpan Peminjaman
                </button>
            </div>

            <div class=" flex justify-center">
                <a href="{{ url('/admin/asset/' . $asset . '/detail') }}"
                    class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg shadow-md hover:bg-gray-300">
                    Kembali
                </a>
            </div>
        </div>
    </form>
</div>