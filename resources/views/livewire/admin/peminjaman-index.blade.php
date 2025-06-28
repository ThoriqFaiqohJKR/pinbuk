<div class="bg-white">
<div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-40 xl:px-48 py-8">
        @foreach ($peminjaman as $data)
        <div class="border border-gray-200 rounded-lg p-4 shadow-sm flex flex-col space-y-4">
            <div class="flex flex-wrap items-center space-x-2 text-gray-900 font-semibold">
                <i class="fas fa-shopping-bag text-lg"></i>
                <span>Peminjaman</span>
                <span class="text-gray-700 font-normal">{{ \Carbon\Carbon::parse($data->tanggal_pinjam)->format('d M Y') }}</span>
                <span class="ml-2 {{ $data->status === 'Dipinjam' ? 'bg-blue-400 text-blue-900' : ($data->status === 'Kembali' ? 'bg-green-400 text-green-900' : 'bg-yellow-400 text-yellow-900') }} font-semibold text-[10px] px-2 py-[2px] rounded">
                    {{ $data->status }}
                </span>
                <span class="text-gray-600 font-normal ml-2 break-all">{{ $data->kode_uniq }}</span>
            </div>
            <div class="flex items-center space-x-2 text-gray-900 font-semibold text-[14px]">
                <i class="fas fa-box text-blue-700"></i>
                <span>{{ Str::startsWith($data->kode_uniq, 'B-') ? 'Buku' : 'Aset' }}</span>
            </div>
            <div class="flex justify-between items-center flex-wrap">
                <div class="flex items-center space-x-3 flex-1 min-w-0">
                    <img alt="Image" class="w-[60px] h-[60px] rounded-sm object-contain flex-shrink-0" src="{{ asset($data->image_url) }}" width="60" height="60" />

                    <div class="min-w-0">
                        <h3 class="font-bold text-[14px] leading-tight max-w-[280px] truncate">{{ $data->nama_barang }}</h3>
                        <p class="text-[12px] text-gray-700 font-normal mt-1 {{ $data->harga_sewa == 0 ? 'invisible' : '' }}">
                            Rp{{ number_format($data->harga_sewa, 2) }}
                        </p>
                    </div>

                </div>
                

            </div>
            <div class="flex justify-end items-center space-x-3">
                <a href="{{ url('/admin/peminjaman/' . $data->id . '/detail') }}" class="text-green-700 font-semibold text-[13px] hover:underline">Lihat Detail Transaksi</a>
            </div>

            @php
            $now = \Carbon\Carbon::now();
            $tglKembali = \Carbon\Carbon::parse($data->tanggal_kembali);
            $isTelat = $data->status === 'Dipinjam' && $tglKembali->lt($now);
            @endphp

            <div class="status-menu mt-2 border border-gray-300 rounded-md bg-white shadow-md p-3 flex items-center justify-between text-sm text-gray-800">
                {{-- Request --}}
                <div class="flex flex-col items-center justify-center w-14 h-14 rounded font-semibold 
      {{ in_array($data->status, ['request', 'Silahkan di Ambil', 'Dipinjam', 'Kembali']) ? 'text-green-700 bg-green-100' : 'text-gray-400' }}">
                    <i class="fas fa-file-alt text-xl mb-1"></i>
                    <span class="text-xs">Request</span>
                </div>

                <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>

                {{-- Silahkan Diambil --}}
                <div class="flex flex-col items-center justify-center w-14 h-14 rounded font-semibold 
      {{ in_array($data->status, ['Silahkan di Ambil', 'Dipinjam', 'Kembali']) ? 'text-green-700 bg-green-100' : 'text-gray-400' }}">
                    <i class="fas fa-hand-paper text-xl mb-1"></i>
                    <span class="text-xs text-center leading-tight">Silahkan<br>di Ambil</span>
                </div>

                <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>

                {{-- Dipinjam --}}
                <div class="flex flex-col items-center justify-center w-14 h-14 rounded font-semibold 
      {{ $data->status === 'Dipinjam' ? ($isTelat ? 'text-red-700 bg-red-100' : 'text-blue-700 bg-blue-100') : ($data->status === 'Kembali' ? 'text-green-700 bg-green-100' : 'text-gray-400') }}">
                    <i class="fas fa-box-open text-xl mb-1"></i>
                    <span class="text-xs">Dipinjam</span>
                </div>

                <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>

                {{-- Kembali --}}
                <div class="flex flex-col items-center justify-center w-14 h-14 rounded font-semibold 
      {{ $data->status === 'Kembali' ? 'text-green-700 bg-green-100' : 'text-gray-400' }}">
                    <i class="fas fa-undo-alt text-xl mb-1"></i>
                    <span class="text-xs">Kembali</span>
                </div>
            </div>

        </div>
        @endforeach
    </div>
</div>