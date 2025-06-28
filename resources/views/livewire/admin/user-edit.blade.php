<div class="container mx-auto p-6">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md overflow-hidden md:max-w-xl">
        <div class="w-full p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Edit Data User</h2>

            @if (session()->has('message'))
                <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="update" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700">nama</label>
                    <input wire:model="nama" type="text" id="nama" class="mt-1 w-full px-3 py-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input wire:model="email" type="email" id="email" class="mt-1 w-full px-3 py-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="no_tlpn" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input wire:model="no_tlpn" type="tel" id="no_tlpn" class="mt-1 w-full px-3 py-2 border rounded-md">
                </div>

                @if($level === 'admin')
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input wire:model="password" type="password" id="password" class="mt-1 w-full px-3 py-2 border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input wire:model="confirm_password" type="password" id="confirm_password" class="mt-1 w-full px-3 py-2 border rounded-md">
                    </div>
                @else 
                    <div class="mb-4">
                        <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                        <input wire:model="jabatan" type="text" id="jabatan" class="mt-1 w-full px-3 py-2 border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select wire:model="status" id="status" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="green">Hijau</option>
                            <option value="yellow">Kuning</option>
                            <option value="red">Merah</option>
                            <option value="black">Hitam</option>
                        </select>
                    </div>
                @endif

                <div class="mb-4">
                    <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                    <input wire:model="foto" type="file" id="foto" class="mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">

                    @if ($foto)
                        <div class="mt-2">
                            <span class="text-sm text-gray-600">Preview:</span>
                            <img src="{{ $foto->temporaryUrl() }}" class="h-20 mt-1 border rounded">
                        </div>
                    @elseif ($foto_old)
                        <div class="mt-2">
                            <span class="text-sm text-gray-600">Foto Lama:</span>
                            <img src="{{ asset('storage/' . $foto_old) }}" class="h-20 mt-1 border rounded">
                        </div>
                    @endif
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Update</button>

                <a href="{{ url('/admin/users') }}" class="block w-full text-center mt-4 bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300">Kembali</a>
            </form>
        </div>
    </div>
</div>
