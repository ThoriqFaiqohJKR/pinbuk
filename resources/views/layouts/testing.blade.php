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
    <div class="w-full border-b-2 border-black sm:px-6 md:px-10 lg:px-20 xl:px-40 py-6 flex flex-col sm:flex-row justify-between items-start gap-6 sm:gap-4">
      <!-- Logo -->
      <div class="flex-shrink-0">
        <a href="{{ route('user.buku.index') }}">
          <img alt="Logo Auriga" src="{{ asset('foto/Logo Auriga.png') }}" class="w-28 sm:w-24 h-auto object-contain" />
        </a>
      </div>

      <!-- Paragraf Tengah -->
      <div class="flex-1 text-[13px] sm:text-[14px] text-black text-left px-30">
        <p class="leading-snug sm:leading-normal font-semibold">
          Diisi dengan tag line Acepellu pturiae molut volora volent, et fuga. Ita earum, tem cullit, nus et, solupta estrum, con corectia cor sequiaspedi alit asincia pliae exero doluptaerume pos aut libus am reres...
        </p>
      </div>

      <!-- Tombol Donasi -->
      <div x-data="{ showModal: false }">

        <!-- Tombol -->
        <div class="flex-shrink-0 mr-6">
          <button @click="showModal = true"
            class="bg-[#1a3a05] hover:bg-green-900 text-white text-xs font-semibold px-8 py-2">
            Donasi Buku:
          </button>
        </div>

        <!-- Modal -->
        <div x-show="showModal"
          class="fixed inset-0 flex items-center justify-center z-50 bg-opacity-50"
          x-transition>
          <div class="bg-white w-full max-w-md  shadow-lg p-6 relative"  @click.outside="showModal = false">
            <h2 class="text-lg font-bold mb-4">Form Donasi Buku</h2>

            <!-- Isi Form di sini -->
            <form>
              <input type="text" placeholder="Judul Buku" class="w-full mb-3 border p-2  " />
              <textarea placeholder="Catatan" class="w-full border p-2   mb-3"></textarea>
              <button type="submit" class="bg-green-700 text-white px-4 py-2  ">Kirim</button>
            </form>

            <!-- Tombol Tutup -->
            <button @click="showModal = false"
              class="absolute top-2 right-3 text-gray-700 hover:text-red-500 text-xl">&times;</button>
          </div>
        </div>

      </div>

    </div>

    <!-- Hak Cipta -->
    <div class="text-center text-[11px] sm:text-[12px] md:text-[11px] lg:text-[12px] xl:text-[9px] text-black py-2 select-none">
      © 2025 <a href="https://auriga.or.id" class="hover:text-auriga font-semibold">AURIGA NUSANTARA</a>. SELURUH HAK CIPTA DILINDUNGI UNDANG-UNDANG.
    </div>

    <!-- Bar Hijau Bawah -->
    <div class="bg-[#1a3a05] h-4"></div>
  </footer>
  @livewireScripts
</body>

</html>