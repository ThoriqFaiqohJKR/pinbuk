<style>
    @media print {
        /* Menyembunyikan seluruh layout kecuali konten utama (invoice) */
        .no-print {
            display: none !important;
        }

        /* Optional: Anda bisa menyesuaikan ukuran layout agar lebih cocok untuk cetakan */
        body {
            margin: 0;
            padding: 0;
        }

        /* Menyesuaikan gaya untuk invoice agar terlihat lebih baik di cetakan */
        .invoice-print {
            display: block !important;
        }
    }

    /* Untuk tampilan normal, pastikan invoice tetap tersembunyi */
    .invoice-print {
        display: none;
    }
</style>

<div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-40 xl:px-48 py-8 ">
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div class="max-w-3xl w-full bg-white shadow-lg border border-gray-500   p-8 mx-auto">
        <header class="mb-8 flex flex-col sm:flex-row sm:justify-between sm:items-center border-b border-gray-200 pb-4">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Invoice Peminjaman</h1>
                <p class="text-gray-600 mt-1">Nomor Invoice:
                    <span class="font-mono font-semibold text-indigo-600">{{ $peminjaman->invoice ?? '-' }}</span>
                </p>
            </div>
            <div class="mt-4 sm:mt-0 text-gray-500 text-sm">
                <time datetime="{{ $peminjaman->tanggal_pinjam }}">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y') }}</time>
            </div>
        </header>

        <section class="mb-8 grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-700">
            <div>
                <h2 class="text-lg font-semibold mb-2 text-gray-800">Data Peminjam</h2>
                <p><span class="font-semibold">Nama:</span> {{ $peminjaman->nama_peminjam ?? '-' }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-2 text-gray-800">Keperluan</h2>
                <p>{{ $peminjaman->keperluan ?? '-' }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-2 text-gray-800">Tanggal Pinjam</h2>
                <p>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y') }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-2 text-gray-800">Tanggal Kembali</h2>
                <p>{{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->translatedFormat('d F Y') : '-' }}</p>
            </div>
            @if($peminjaman->catatan)
            <div class="sm:col-span-2">
                <h2 class="text-lg font-semibold mb-2 text-gray-800">Catatan</h2>
                <p class="text-gray-600">{{ $peminjaman->catatan }}</p>
            </div>
            @endif
        </section>

        <section class="mb-8">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Detail Barang yang Dipinjam</h2>

            @if($peminjaman->harga_sewa > 0)
            {{-- Barang disewa --}}
            <div class="hidden sm:grid border border-gray-300   bg-indigo-50 text-indigo-700 grid-cols-4 text-center font-semibold py-3 px-4">
                <div>Nama Barang</div>
                <div>Harga Sewa / Hari</div>
                <div>Jumlah Hari</div>
                <div>Total Harga</div>
            </div>
            <div class="hidden sm:flex flex-col">
                <div class="grid grid-cols-4 text-center text-gray-700 border-x border-b border-gray-300 py-3 px-4">
                    <div>{{ $peminjaman->nama_barang ?? '-' }}</div>
                    <div>Rp {{ number_format($peminjaman->harga_sewa, 0, ',', '.') }}</div>
                    <div>{{ $peminjaman->jumlah_hari ?? '-' }}</div>
                    <div class="font-semibold">Rp {{ number_format($peminjaman->total_sewa, 0, ',', '.') }}</div>
                </div>
            </div>
            @else
            {{-- Barang hanya dipinjam (tanpa sewa) --}}
            <div class="border border-gray-300   text-gray-700 px-4 py-3">
                <div class="flex justify-between font-semibold">
                    <span>Nama Barang:</span>
                    <span>{{ $peminjaman->nama_barang ?? '-' }}</span>
                </div>
                <div class="flex justify-between mt-2">
                    <span>Total Peminjaman:</span>
                    <span>{{ $this->jumlahHari ? $this->jumlahHari . ' hari' : '-' }}</span>
                </div>

            </div>
            @endif
        </section>


        <section class="flex flex-col sm:flex-row sm:justify-end sm:items-center gap-4 mt-4">
            @if($peminjaman->harga_sewa > 0)
            <div class="text-gray-700 text-lg font-semibold">
                Total Sewa: <span class="text-indigo-600">Rp {{ number_format($peminjaman->total_sewa, 0, ',', '.') }}</span>
            </div>
            @endif

            <div>
                <span class="inline-block px-4 py-2  text-white font-semibold text-sm
            {{ $peminjaman->status === 'Selesai' ? 'bg-green-600' : 'bg-yellow-500' }}">
                    {{ ucfirst($peminjaman->status) }}
                </span>
            </div>
        </section>


      


    </div>

    <section class="flex pl-48 gap-4 mt-4 no-print">
            <!-- Button Edit -->
            <a href="{{ url('/admin/peminjaman/' . $peminjaman->id . '/edit') }}" class="px-6 py-2 bg-blue-600 text-white   text-sm font-semibold hover:bg-blue-700">
                Edit
            </a>

            <!-- Button Cetak -->
            <button onclick="window.print()" class="px-6 py-2 bg-green-600 text-white   text-sm font-semibold hover:bg-green-700">
                Cetak
            </button>
        </section>
</div>