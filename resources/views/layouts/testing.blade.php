<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  </script>
  <title>@yield('title', 'Dashboard')</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;1,100&display=swap');

    p {
      font-family: "Poppins", sans-serif;

      font-style: normal;
    }
  </style>
  @vite('resources/css/app.css')
  @livewireStyles


</head>

<body x-data="{ showModal: false }" @keydown.escape.window="showModal = false" class="flex flex-col min-h-screen">


  <!--navbar-->
  <div class="w-full sticky top-0 bg-white z-[99999999]">

    <div class="bg-[#1a3a05] text-white text-xs font-semibold flex justify-end py-2 px-6 sm:px-6 md:px-14 lg:px-20 xl:px-46 2xl:px-46">
      <a class="hover:underline" href="#">Buku terbaru</a>
      <a class="hover:underline ml-9" href="#">Hubungi kami</a>
    </div>
    @php
    use Illuminate\Support\Facades\DB;
    $userId = session('user_id');
    $user = $userId ? DB::table('pengguna')->where('id', $userId)->first() : null;
    @endphp

    <header class="flex items-center  py-2 px-2 sm:px-6 md:px-10 lg:px-20 xl:px-40">
      <!-- Kiri: Logo + Kategori -->
      <div class="flex items-center flex-shrink-0 mr-2 sm:mr-4 md:mr-4 lg:mr-4 xl:mr-2 gap-4 sm:gap-8 md:gap-12 lg:gap-20 xl:gap-34">

        <div class="w-16 h-12 sm:w-20 sm:h-14 lg:w-24 lg:h-16 flex items-center justify-center">
          <a href="{{ route('user.buku.index') }}">
            <img alt="Auriga company logo in gray background with white text, rectangular shape with stylized text Auriga Nusantara" src="{{asset('foto/Logo Auriga.png') }}" class="w-full h-full object-contain" />
          </a>

        </div>




        <label
          class="hidden sm:inline font-bold text-sm cursor-pointer"
          @click.prevent="showModal = !showModal">
          Kategori
        </label>
      </div>

      <!-- Kanan: Input + User Info -->
      <div class="flex items-center justify-between w-full relative">
        <!-- Input -->
        <div class="flex-1 min-w-0 border border-black text-sm  focus:outline-none focus:ring-1 focus:ring-green-700 mr-4 sm:mr-6 md:mr-10 lg:mr-29 xl:mr-34">
          @livewire('user.search-navbar')
        </div>



        <!-- User Info -->
        <div
          x-data="{ dropdownOpen: false, isMobile: false }"
          x-init="
    isMobile = window.innerWidth < 640;
    window.addEventListener('resize', () => {
      isMobile = window.innerWidth < 640;
      if (!isMobile) dropdownOpen = false; // reset dropdown saat pindah layar
    });
  "
          @mouseenter="if(!isMobile) dropdownOpen = true"
          @mouseleave="if(!isMobile) dropdownOpen = false"
          @click="if(isMobile) dropdownOpen = !dropdownOpen"
          @click.away="dropdownOpen = false"
          class="relative flex items-center space-x-2 sm:space-x-2 flex-shrink-0 cursor-pointer select-none sm:mr-0 mr-3 sm:ml-0 ml-auto">
          <!-- Avatar -->
          <img
            alt="User avatar"
            class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 lg:w-10 lg:h-10 rounded-full border-red-600 object-cover"
            src="{{asset('foto/pp.jpeg') }}" />


          <p class="font-bold text-sm sm:flex pr-3 hidden">
            Hi,
            <span>Pengguna</span>
          </p>

          <!-- Panah hanya untuk mobile -->
          <p class="font-bold text-sm sm:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
              <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
          </p>

          <!-- Dropdown -->
          <div
            x-show="dropdownOpen"
            @click.away="dropdownOpen = false"
            class="absolute right-0 top-full mt-2 w-34 bg-white border border-gray-300 z-50 shadow-md"
            x-transition>


            <a href="{{ route('user.buku.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">Buku</a>

            <a href="{{ route('user.peminjaman.index')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">Riwayat</a>

            <form id="logout-form" method="POST" action="{{ route('user.logout') }}">
              @csrf
              <a href="#"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
              </a>
            </form>





          </div>
        </div>
      </div>
    </header>


    <!-- Navigation -->
    <div class="flex justify-center">
      <header

        class="hidden lg:flex justify-center -translate-y-6">
        <nav class="flex justify-center lg:gap-[1.6rem] 2xl:gap-[1.8rem] text-[13px] text-black w-full">
          <a class="hover:underline" href="{{ route('user.buku.katalog', 1)}}">Hutan</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 2)}}">Kebun</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 3)}}">Tambang & Energi</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 7)}}">Laut</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 4)}}">Hukum</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 8)}}">Keuangan</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 5)}}">Novel</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 6)}}">Lainnya</a>
        </nav>
      </header>
    </div>

    <div class="border-b border-red-500 -mt-2 sm:-mt-3 md:-mt-1"></div>
  </div>

  <!-- Modal -->
  <div
    x-show="showModal"
    x-transition
    x-cloak
    @click.self="showModal = false"
    class="fixed inset-0 z-[199999999] flex items-start justify-center pt-24 px-4 sm:px-6 md:px-60 lg:px-82 xl:px-114">
    <div class="bg-white border border-gray-300 shadow-lg w-full 
              px-4 sm:px-6 md:p-8 lg:p-6 xl:p-6">
      <div class="flex flex-col space-y-6">

        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 1)}}">Hutan</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 2)}}">Kebun</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 3)}}">Tambang dan Energi</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 7)}}">Laut</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 4)}}">Hukum</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 8)}}">Keuangan</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 5)}}">Novel</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 6)}}">Lainnya</a>
      </div>
    </div>
  </div>
  <!--navbar-->


  <!--content-->


  <div class="flex-1">
    @yield('content')
  </div>



  <!--footer-->
  <footer class="border-t border-red-600 mt-auto bg-white poppins-regular">
    <div class="flex flex-col sm:flex-row mt-2 justify-between px-4 sm:px-8 md:px-12 lg:px-20 xl:px-40 py-4 border-b-2 border-black space-y-4 sm:space-y-0">

      <!-- Logo kiri -->
      <div class="sm:w-auto w-full flex justify-center sm:justify-start">
        <a href="{{ route('user.buku.index') }}">
          <img alt="Logo Auriga" src="{{asset('foto/Logo Auriga.png') }}" class="w-28 sm:w-24 h-auto object-contain" />
        </a>
      </div>

      <!-- Teks tengah -->
      <div class="text-sm text-center sm:text-left sm:flex-1 sm:px-42">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sequi eius cum vitae et minima, modi, culpa illo dolorum pariatur labore dolore aperiam at aliquam repudiandae temporibus non ad omnis blanditiis. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sequi eius cum vitae et minima, modi, culpa illo dolorum pariatur labore dolore aperiam at aliquam repudiandae temporibus non ad omnis blanditiis.
      </div>

      <!-- Tombol kanan -->
      <div x-data="{ showModal: false }">

        <!-- Tombol -->
        <div class="sm:w-auto w-full flex sm:justify-end">
          <button @click="showModal = true" class="bg-[#1a3a05] text-white px-6 py-2   hover:bg-green-700 transition duration-300 text-xs">
            Donasi Buku
          </button>
        </div>

        <!-- Modal -->
        <div x-show="showModal" class="fixed inset-0 flex items-center justify-center z-50"
          x-transition>
          <div class="bg-white  shadow-lg border w-11/12 max-w-md p-6" @click.away="showModal = false">
            <h2 class="text-lg font-semibold mb-4">Form Donasi Buku</h2>

            <!-- Isi form -->

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full">

              <!-- Tombol Email -->
              <a href="mailto:example@email.com" target="_blank" class="w-full">
                <button class="w-full bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition text-sm">
                  📧 Kirim Email
                </button>
              </a>

              <!-- Tombol WhatsApp -->
              <a href="https://wa.me/6281234567890" target="_blank" class="w-full">
                <button class="w-full bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 transition text-sm">
                  💬 WhatsApp Kami
                </button>
              </a>

            </div>




          </div>
        </div>

      </div>


    </div>

    <div class="text-center text-[11px] sm:text-[12px] md:text-[11px] lg:text-[12px] xl:text-[9px] text-black py-2 select-none">
      © 2025 <a href="https://auriga.or.id" class="hover:text-auriga font-semibold">AURIGA NUSANTARA</a>. SELURUH HAK CIPTA DILINDUNGI UNDANG-UNDANG.
    </div>

    <div class="bg-[#1a3a05] text-white text-xs font-semibold flex justify-end px-6 sm:px-36 py-2">
    </div>
  </footer>
  @livewireScripts
</body>

</html>