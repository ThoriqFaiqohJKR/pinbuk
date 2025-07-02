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
        <div class="flex-1 min-w-0 border border-black text-sm   focus:outline-none focus:ring-1 focus:ring-green-700 mr-4 sm:mr-6 md:mr-10 lg:mr-29 xl:mr-41">
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
        <nav class="flex justify-center lg:gap-[1.6rem] 2xl:gap-[2.4rem] text-[13px] text-black w-full">
          <a class="hover:underline" href="{{ route('user.buku.katalog', 1)}}">Hutan</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 2)}}">Kebun</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 3)}}">Tambang dan Energi</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 4)}}">Hukum</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 5)}}">Novel</a>
          <a class="hover:underline" href="{{ route('user.buku.katalog', 6)}}">Lainnya</a>
        </nav>
      </header>
    </div>

    <div class="border-b border-red-500 -mt-3"></div>
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
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 1)}}">Hukum</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 2)}}">Hutan</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 3)}}">Kebun</a>
        <a class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 4)}}">Tambang dan Energi</a>
        <p class="font-bold text-sm leading-tight hover:underline" href="{{ route('user.buku.katalog', 5)}}">Novel</a>
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
    <div class="flex flex-col sm:flex-row items-start sm:items-center px-4 sm:px-8 md:px-12 lg:px-20 xl:px-44 py-4 border-b-2 border-black">
      <div class="mx-auto sm:mx-0">
        <a href="{{ route('user.buku.index') }}">
          <img alt="Auriga company logo in gray background with white text, rectangular shape with stylized text Auriga Nusantara" src="{{asset('foto/Logo Auriga.png') }}" class="w-24 h-12 object-contain" />
        </a>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:flex flex-wrap gap-x-6 sm:gap-x-4 md:gap-x-6 lg:gap-x-12 xl:gap-x-12 2xl:gap-x-16 gap-y-2 text-xs text-black px-4 sm:px-4 md:px-20 lg:px-22 xl:px-44 2xl:px-54 w-full justify-start mt-4 text-left">

        <a class="font-semibold hover:underline" href="{{ route('user.buku.katalog', 1)}}">Hutan</a>
        <a class="font-semibold hover:underline" href="{{ route('user.buku.katalog', 2)}}">Kebun</a>
        <a class="font-semibold hover:underline" href="{{ route('user.buku.katalog', 3)}}">Tambang dan Energi</a>
        <a class="font-semibold hover:underline" href="{{ route('user.buku.katalog', 4)}}">Hukum</a>
        <a class="font-semibold hover:underline" href="{{ route('user.buku.katalog', 5)}}">Novel</a>
        <a class="font-semibold hover:underline" href="{{ route('user.buku.katalog', 6)}}">Lainnya</a>
      </div>




    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-8 md:px-12 lg:px-20 xl:px-36 pb-1 text-center text-[11px] sm:text-[12px] md:text-[11px] lg:text-[12px] xl:text-[9px] text-black select-none py-2">
      © 2025 AURIGA NUSANTARA. SELURUH HAK CIPTA DILINDUNGI UNDANG-UNDANG.
    </div>
    <div class="bg-[#1a3a05] text-white text-xs font-semibold flex justify-end px-6 sm:px-36 py-2">
    </div>
  </footer>
  @livewireScripts
</body>

</html>