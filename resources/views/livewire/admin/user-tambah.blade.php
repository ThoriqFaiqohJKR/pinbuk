<div class="container mx-auto p-6">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md overflow-hidden md:max-w-xl">
        <div class="md:flex">
            <div class="w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-700">User Registration Form</h2>
                    <a href="#" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300">Kembali</a>
                </div>
                <form wire:submit.prevent="store" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                        <input wire:model="nip" type="text" id="nip" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                        @error('nip') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700">nama</label>
                        <input wire:model="nama" type="text" id="nama" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                        @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input wire:model="email" type="email" id="email" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                        <select wire:model="jabatan" id="jabatan" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                            <option value="">-- Pilih Jabatan --</option>

                            <optgroup label="Pimpinan">
                                <option value="Ketua Yayasan">Ketua Yayasan</option>
                                <option value="Deputi Kelembagaan">Deputi Kelembagaan</option>
                                <option value="PJ Direktur Kehutanan">PJ Direktur Kehutanan</option>
                                <option value="Direktur Informasi dan Data">Direktur Informasi dan Data</option>
                                <option value="Monitoring dan Evaluasi">Monitoring dan Evaluasi</option>
                                <option value="Direktur Penegak Hukum">Direktur Penegak Hukum</option>
                                <option value="Direktur Komunikasi dan Advokasi">Direktur Komunikasi dan Advokasi</option>
                                <option value="Direktur Perkebunan">Direktur Perkebunan</option>
                                <option value="Direktur Tambang dan Energi">Direktur Tambang dan Energi</option>
                            </optgroup>

                            <optgroup label="Staf Direktorat">
                                <option value="Staf Direktorat Kehutanan">Staf Direktorat Kehutanan</option>
                                <option value="Staf Direktorat Informasi dan Data">Staf Direktorat Informasi dan Data</option>
                                <option value="Staf Direktorat Penegakan Hukum">Staf Direktorat Penegakan Hukum</option>
                                <option value="Staf Direktorat Komunikasi dan Advokasi">Staf Direktorat Komunikasi dan Advokasi</option>
                                <option value="Staf Direktorat Perkebunan">Staf Direktorat Perkebunan</option>
                                <option value="Staf Direktorat Tambang dan Energi">Staf Direktorat Tambang dan Energi</option>
                            </optgroup>

                            <optgroup label="Biro">
                                <option value="Biro Administrasi">Administrasi</option>
                                <option value="Biro Keuangan">Keuangan</option>
                                <option value="Biro Kerumahtanggaan">Kerumah Tanggaan</option>
                                <option value="Teknologi dan Informasi">Teknologi dan Informasi</option>
                                <option value="kepala Biro Keuangan">Kepala Biro Keuangan</option>
                                <option value="Staf Keuangan">Staf Keuangan</option>
                            </optgroup>
                        </select>
                        @error('jabatan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="no_tlpn" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input wire:model="no_tlpn" type="tel" id="no_tlpn" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                        @error('no_tlpn') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                        <input wire:model="photo" type="file" id="photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        @if ($photo)
                        <div class="mt-2">
                            <img src="{{ $photo->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-md border" height="128" width="128">
                        </div>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input wire:model="password" type="password" id="password" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input wire:model="confirm_password" type="password" id="confirm_password" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                        @error('confirm_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div></div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>