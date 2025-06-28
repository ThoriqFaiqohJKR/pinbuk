<div class="max-w-5xl mx-auto bg-white p-8 border border-gray-500 shadow-xl border border-gray-200 my-10">
    <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Edit Peminjaman</h1>

    <form wire:submit.prevent="updateStatus">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Peminjam -->
            <div>
                <label class="block text-gray-700 font-medium">Nama Peminjam</label>
                <input type="text" value="{{ $nama_peminjam }}" class="w-full p-4 mt-2 border     bg-gray-100 text-gray-700" readonly>
            </div>

            <!-- Barang/Buku -->
            <div>
                <label class="block text-gray-700 font-medium">Barang/Buku</label>
                <input type="text" value="{{ $barang }}" class="w-full p-4 mt-2 border     bg-gray-100 text-gray-700" readonly>
            </div>

            <!-- Tanggal Pinjam -->
            <div>
                <label class="block text-gray-700 font-medium">Tanggal Pinjam</label>
                <input type="date" wire:model="tanggal_pinjam" class="w-full p-4 mt-2 border     bg-gray-100 text-gray-700" readonly>
            </div>

            <!-- Tanggal Kembali -->
            <div>
                <label class="block text-gray-700 font-medium">Tanggal Kembali</label>
                <input type="date" wire:model="tanggal_kembali" class="w-full p-4 mt-2 border     bg-gray-100 text-gray-700" readonly>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-gray-700 font-medium">Status</label>
                <select wire:model="status" class="w-full p-4 mt-2 border     bg-gray-100 text-gray-700">
                    <option value="" disabled>Pilih status</option>
                    <option value="Request" @if(in_array($statusAwal, ['Request','Silahkan di Ambil','Dipinjam','Kembali','Hilang'])) disabled @endif>Request</option>
                    <option value="Silahkan di Ambil" @if(in_array($statusAwal, ['Silahkan di Ambil','Dipinjam','Kembali','Hilang'])) disabled @endif>Silahkan di Ambil</option>
                    <option value="Dipinjam" @if(in_array($statusAwal, ['Dipinjam','Kembali','Hilang'])) disabled @endif>Dipinjam</option>
                    <option value="Kembali" @if($statusAwal==='Hilang' ) disabled @endif>Kembali</option>
                </select>
            </div>


            <!-- Keperluan -->
            @if ($status === 'Silahkan di Ambil'|| $status === 'Dipinjam' || $status === 'Kembali')
            <!-- Keperluan -->
            <div>
                <label class="block text-gray-700 font-medium">Keperluan</label>
                <input type="text" wire:model="keperluan"
                    class="w-full p-4 mt-2 border     bg-gray-100 text-gray-700"
                    @if($this->readonlyInput) readonly @endif required>
            </div>

            <!-- Catatan -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 font-medium">Catatan</label>
                <textarea wire:model="catatan" rows="4"
                    class="w-full p-4 mt-2 border     bg-gray-100 text-gray-700"
                    @if($this->readonlyInput) readonly @endif></textarea>
            </div>


            <!-- Harga Sewa -->
            @if (!Str::startsWith($kode_uniq, 'B-'))
            <!-- Harga Sewa -->
            <div>
                <label class="block text-gray-700 font-medium">Harga Sewa</label>
                <input type="number" wire:model="harga_sewa" step="0.01" min="0"
                    class="w-full p-4 mt-2 border     bg-gray-100 text-gray-700"
                    @if($this->readonlyStatus) readonly @endif>
            </div>

            <!-- Invoice -->
            <div>
                <label class="block text-gray-700 font-medium">Invoice</label>
                <input type="text" wire:model="invoice"
                    class="w-full p-4 mt-2 border     bg-gray-100 text-gray-700"
                    @if($this->readonlyStatus) readonly @endif>
            </div>
            @endif

            @endif

            <!-- Kondisi (jika status == Kembali) -->
            @if ($status === 'Dipinjam' || $status === 'Kembali')
            <div class="md:col-span-2">
                <label class="block text-gray-700 font-medium">Kondisi Barang Saat Dikembalikan</label>

                <select wire:model="kondisi"
                    class="w-full p-4 mt-2 border     bg-white text-gray-700"
                    @if($status==='Kembali' ) disabled @endif {{-- non-editable saat Kembali --}}
                    required>
                    <option value="">Pilih kondisi</option>
                    <option value="baik">Baik</option>
                    <option value="rusak">Rusak</option>
                    <option value="hilang">Hilang</option>
                </select>

                {{-- hidden agar nilai tetap terkirim ketika select disabled --}}
                @if($status === 'Kembali')
                <input type="hidden" name="kondisi" value="{{ $kondisi }}">
                @endif
            </div>
            @endif

        </div>

        <!-- Tombol -->
        <div class="flex justify-center mt-10">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3  shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Simpan Status
            </button>
        </div>
    </form>
</div>