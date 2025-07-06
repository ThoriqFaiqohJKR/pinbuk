<div>

  {{-- If your happiness depends on money, you will never be happy with yourself. --}}

  <div wire:poll.4s="nextSlide" class="mt-10 mx-auto flex flex-col items-center px-4 sm:px-6 md:px-8 lg:px-12 xl:px-24 ">

    @if (count($books) > 0)
    <!-- Kotak 16:9 -->
      <a href="{{ route('user.buku.detail', ['id' => $books[$currentIndex]->id]) }}" class="block w-full max-w-[680px] mx-auto">
        <div class="aspect-[16/9] bg-white shadow-lg border border-gray-300 flex overflow-hidden">

          <!-- Gambar -->
          <div class="w-1/2 flex items-center justify-center bg-gray-100">
            <div class="w-[100px] sm:w-[220px] aspect-[1/1.4142] overflow-hidden shadow">
              <img src="{{ $books[$currentIndex]->foto_buku }}" alt="Judul Buku" class="w-full h-full object-cover">
            </div>
          </div>

          <!-- Teks -->
          <div class="w-1/2 p-4 flex flex-col py-7">

            <h2 class="text-sm sm:text-lg font-bold mb-2">{{ $books[$currentIndex]->nama_buku }}</h2>
            <p class="text-[10px] sm:text-[12px] text-gray-700 line-clamp-5">{{ $books[$currentIndex]->ringkasan }}</p>
          </div>

        </div>
      </a>
    <!-- Caption bawah -->
    <h3 class="font-semibold text-sm text-black mt-2 text-left w-full sm:w-[680px]">
      {{ $books[$currentIndex]->nama_buku }}
    </h3>

    <!-- Dots navigasi manual -->
    <div class="flex justify-center space-x-2">
      @foreach ($books as $index => $book)
      <span wire:click="goToSlide({{ $index }})"
        class="w-2 h-2 rounded-full block cursor-pointer
                        {{ $index === $currentIndex ? 'bg-black' : 'bg-gray-300' }}">
      </span>
      @endforeach
    </div>
    @else
    <p class="text-gray-500">Tidak ada buku yang ditampilkan.</p>
    @endif
  </div>


  <!-- Kategori Buku -->
  <div class="bg-white pt-4   px-4 sm:px-6 md:px-12 lg:px-20 xl:px-48  poppins-regular">


    <div class="max-w-[1155px] mx-auto">



      @foreach ($kategoriBuku as $kategori)
      <div
        class="relative mb-16"
        x-data="{
        showLeft: false,
        showRight: true,
        scrollEl: null,
        checkScroll() {
            if (!this.scrollEl) return;
            this.showLeft = this.scrollEl.scrollLeft > 0;
            this.showRight = this.scrollEl.scrollLeft + this.scrollEl.clientWidth < this.scrollEl.scrollWidth - 1;
        },
        init() {
            this.scrollEl = $refs.carousel;
            this.checkScroll();
            this.scrollEl.addEventListener('scroll', () => this.checkScroll());
        }
    }"
        x-init="init">
        <a
          href="{{ url('/user/buku/' . $kategori->id . '/katalog') }}">
          <h2 class="text-xs font-bold mt-2 hover:underline">{{ $kategori->nama }}</h2>
        </a>


        <!-- Tombol Scroll Kiri -->
        <button
          x-show="showLeft"
          x-transition
          aria-label="Scroll Left"
          @click="scrollEl.scrollBy({ left: -240, behavior: 'smooth' })"
          class="absolute left-[-20px] top-1/2 -translate-y-1/2 z-10 bg-gray-300 rounded-full w-8 h-8 hidden sm:flex items-center justify-center text-gray-600 hover:text-gray-800">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            class="w-4 h-4 text-gray-700 font-bold">
            <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
          </svg>

        </button>

        <!-- Carousel -->
        <div
          x-ref="carousel"
          class="overflow-x-auto scroll-smooth whitespace-nowrap flex gap-2 sm:gap-11 hide-scrollbar py-1">

          @if ($kategori->buku->isEmpty())
          <div class="text-gray-500 text-sm px-4 py-6"> 
            Tidak ada buku yang tersedia.
          </div>
          @else
          @foreach ($kategori->buku as $buku)
          @if($buku->total_stok < 1)
            <a
            aria-disabled="true"
            class="relative pointer-events-none border border-gray-100 aspect-square w-48 h-48 flex-shrink-0 bg-white shadow-sm  flex flex-col transform transition-transform duration-200 hover:scale-100 hover:shadow-md hover:border-gray-400 cursor-not-allowed select-none opacity-70"
            href="#"
            tabindex="-1">
            @else
            <a
              href="{{ url('/user/buku/' . $buku->id . '/detail') }}"
              class="border aspect-square w-48 flex-shrink-0 bg-white border-abu shadow-sm h-48 flex flex-col transform transition-transform duration-200 hover:scale-100 hover:shadow-md hover:border-auriga hover:border-2">
              @endif

              <!-- Label Stok Habis -->


              <!-- Gambar Buku -->
              <div class="p-2 min-h-[72px]">
                <p class="font-semibold text-xs break-words whitespace-normal leading-snug line-clamp-3">
                  {{ $buku->nama_buku }}
                </p>

              </div>

              <!-- Gambar -->
              <div class="flex-1 bg-gray-600 w-full flex items-center justify-center overflow-hidden">

                <img src="{{ $buku->foto_buku ?? asset('images/placeholder.png') }}" alt="Buku"
                  class="w-full h-full object-cover object-{{$buku->position_foto}} " />
              </div>
              <div class="object-center"></div>
              <div class="object-top"></div>
              <div class="object-bottom"></div>

            </a>

            @endforeach

            @endif
        </div>


        <!-- Tombol Scroll Kanan -->
        <button
          x-show="showRight"
          x-transition
          aria-label="Scroll Right"
          @click="scrollEl.scrollBy({ left: 240, behavior: 'smooth' })"
          class="absolute right-[-18px] top-1/2 -translate-y-1/2 z-10 bg-gray-300 rounded-full w-8.5 h-8 flex items-center justify-center text-gray-600 hover:text-gray-800">
          <svg xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            class="w-4 h-4 text-gray-700 font-bold">
            <path stroke-linecap="round"
              stroke-linejoin="round"
              d="M5.25 4.5l7.5 7.5-7.5 7.5m6-15l7.5 7.5-7.5 7.5" />
          </svg>

        </button>
      </div>
      @endforeach

    </div>

    <style>
      .hide-scrollbar::-webkit-scrollbar {
        display: none;
      }

      .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
      }
    </style>
  </div>

</div>