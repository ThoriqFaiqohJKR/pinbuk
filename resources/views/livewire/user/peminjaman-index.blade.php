<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="bg-white py-6 font-sans px-6 sm:px-48 space-y-6 ">
        @forelse ($peminjamanList as $item)
        @php
        $statusLabel = [
        'request' => ['bg' => 'bg-yellow-400', 'text' => 'text-yellow-900', 'label' => 'Request'],
        'silahkan di ambil' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Silahkan diambil'],
        'dipinjam' => ['bg' => 'bg-blue-400', 'text' => 'text-white', 'label' => 'Dipinjam'],
        'selesai' => ['bg' => 'bg-green-400', 'text' => 'text-green-900', 'label' => 'Selesai'],
        'jatuh tempo' => ['bg' => 'bg-red-400', 'text' => 'text-red-900', 'label' => 'Jatuh Tempo'],
        ];
        $status = strtolower($item->status);
        $statusInfo = $statusLabel[$status] ?? $statusLabel['dipinjam'];
        @endphp

        <div class="border border-gray-200  p-4 shadow-sm flex flex-col space-y-4">
            <div class="flex flex-wrap items-center space-x-2 text-gray-900 font-semibold">
                <i class="fas fa-shopping-bag text-lg"></i>
                <span>{{ ucfirst($item->status) }}</span>

                <span class="text-gray-700 font-normal">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</span>
                <span class="ml-2 {{ $statusInfo['bg'] }} {{ $statusInfo['text'] }} font-semibold text-[10px] px-2 py-[2px] ">
                    {{ ucfirst($statusInfo['label']) }}
                </span>
                <span class="text-gray-600 font-normal ml-2 break-all">
                    {{ $item->jenis }}
                </span>

            </div>

            <div class="flex items-center space-x-2 text-gray-900 font-semibold text-[14px]">
                <i class="fas {{ strpos($item->kode_uniq, 'B') === 0 ? 'fa-book text-green-700' : 'fa-cogs text-blue-700' }}"></i>
                <span>{{ strpos($item->kode_uniq, 'B') === 0 ? 'Buku' : 'Aset' }}</span>
            </div>


            <div class="flex justify-between items-center flex-wrap">
                <div class="flex items-center space-x-3 flex-1 min-w-0">
                    <img
                        alt="Gambar barang"
                        class="w-[60px] h-[60px]  object-contain flex-shrink-0"
                        src="{{ $item->gambar }}"
                        width="60"
                        height="60" />
                    <div class="min-w-0">
                        <h3 class="font-bold text-[14px] leading-tight max-w-[280px] truncate">
                            {{ $item->nama ?? 'Nama Tidak Ada' }}
                        </h3>

                        <p class="text-[12px] text-gray-700 font-normal mt-1 min-h-[18px]">
                            @if ($item->harga_sewa)
                            1 barang x Rp{{ number_format($item->harga_sewa, 0, ',', '.') }}
                            @else
                            &nbsp;
                            @endif
                        </p>
                    </div>

                </div>


            </div>

            <div class="flex justify-end items-center space-x-3">
                <button class="text-green-700 font-semibold text-[13px] hover:underline" type="button">
                    Lihat Detail Transaksi
                </button>
            </div>

            {{-- Status Timeline --}}
            @php
            $steps = ['Request', 'Silahkan di Ambil', 'Dipinjam', 'Kembali'];
            $currentIndex = collect($steps)
            ->map(fn($s) => strtolower($s))
            ->search(strtolower($item->status));

            @endphp

            <div class="status-menu mt-2 border border-gray-300  bg-white shadow-md p-3 flex items-center justify-between text-sm text-gray-800">
                @foreach ($steps as $index => $step)
                @php
                $isPastOrCurrent = $index <= $currentIndex;
                    $textColor=$isPastOrCurrent ? 'text-green-600' : 'text-gray-400' ;
                    @endphp
                    <div class="flex flex-col items-center justify-center w-14 h-14   font-semibold {{ $textColor }}">
                    <i class="fas 
           @if(strtolower($step) === 'request') fa-file-alt 
@elseif(strtolower($step) === 'silahkan di ambil') fa-hand-paper 
@elseif(strtolower($step) === 'dipinjam') fa-box-open 
@elseif(strtolower($step) === 'kembali') fa-undo-alt 


                @endif text-xl mb-1">
                    </i>
                    <span class="text-xs text-center leading-tight whitespace-normal break-words w-full">{{ $step }}</span>
            </div>
            @if (!$loop->last)
            <div class="flex-1 h-0.5 {{ $index < $currentIndex ? 'bg-green-600' : 'bg-gray-300' }} mx-2"></div>
            @endif
            @endforeach
        </div>

    </div>
    @empty
    <div class="text-sm text-gray-600">Kamu belum meminjam apa pun.</div>
    @endforelse
</div>
</div>