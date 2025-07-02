<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="px-4 sm:px-12 md:px-12 lg:px-18 lg:px-24 xl:px-42 2xl:px-42 py-6">
        <h2 class="text-xl font-bold mb-4">Hasil untuk: "{{ $keyword }}"</h2>

        @if ($results->count())
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 lg:grid-cols-5 2xl:grid-cols-5 gap-12 sm:gap-2 md:gap-4 lg:gap-8  xl:gap-12 2xl:gap-12">

            @foreach ($results as $buku)
            @php
            $objectClass = match($buku->position_foto ?? 'center') {
            'top' => 'object-top',
            'bottom' => 'object-bottom',
            default => 'object-center'
            };
            $foto = $buku->foto_buku ? asset('storage/' . $buku->foto_buku) : asset('images/placeholder.png');
            @endphp

            <a
                href="{{ $buku->stok < 1 ? '#' : url('/user/buku/' . $buku->id . '/detail') }}"
                class="aspect-square flex flex-col border bg-white transition-transform duration-200 sm:w-48 sm:h-48 w-full h-auto

          {{ $buku->stok < 1 
              ? 'pointer-events-none opacity-70 cursor-not-allowed border-gray-200 hover:shadow-md'
              : 'hover:scale-105 hover:border-green-500 hover:shadow-md border-abu' }}"
                aria-disabled="{{ $buku->stok < 1 ? 'true' : 'false' }}">
                <!-- Judul -->
                <div class="p-2 min-h-[72px]">
                    <p class="font-semibold text-xs break-words whitespace-normal leading-snug line-clamp-3">
                        {{ $buku->nama_buku }}
                    </p>
                </div>

                <!-- Gambar -->
                <div class="flex-1 bg-gray-600 w-full flex items-center justify-center overflow-hidden">
                    <img
                        src="{{ $buku->foto_buku }}"
                        alt="{{ $buku->nama_buku }}"
                        class="w-full h-full object-cover {{ $objectClass }}" />
                </div>
            </a>
            @endforeach
        </div>
        @else
        <p class="text-gray-500">Tidak ada buku ditemukan.</p>
        @endif
    </div>

</div>