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

    <div class="bg-[#1a3a05] text-white text-xs font-semibold flex justify-end py-2 sm:pl-4 px-6 sm:px-[11.4rem]">
      <a class="hover:underline" href="#">Buku terbaru</a>
      <a class="hover:underline ml-9" href="#">Hubungi kami</a>
    </div>
    @php
    use Illuminate\Support\Facades\DB;
    $userId = session('user_id');
    $user = $userId ? DB::table('pengguna')->where('id', $userId)->first() : null;
    @endphp
    <header class="flex items-center  py-2 sm:px-[10.5rem]">
      <!-- Kiri: Logo + Kategori -->
      <div class="flex items-center gap-[9.9rem] flex-shrink-0 mr-[0.8rem]">

        <div class="w-24 h-16 lg:w-24 lg:h-16 sm:w-12 sm:h-12 flex items-center justify-center">
          <img alt="Auriga company logo in gray background with white text, rectangular shape with stylized text Auriga Nusantara" class="sm:w-24 sm:h-12" height="64" src="{{asset('storage/foto/Logo Auriga.png') }}" width="96" />

        </div>




        <label
          class="font-bold text-sm hidden sm:block cursor-pointer"
          @click.prevent="showModal = !showModal">
          Kategori
        </label>
      </div>

      <!-- Kanan: Input + User Info -->
      <div class="flex items-center justify-between w-full relative">
        <!-- Input -->
        <input
          id="kategori"
          type="text"
          placeholder="Cari kategori..."
          aria-label="Kategori"
          class="border border-black text-sm py-1 px-2 w-full lg:mr-36 sm:mr-12 mr-6   max-w-full sm:max-w-none" />


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
          @if(isset($user))
          <!-- Avatar -->
          @php
          $statusColors = [
          'red' => 'border-red-500',
          'green' => 'border-green-500',
          'yellow' => 'border-yellow-500',
          'black' => 'border-black',
          ];

          $borderClass = $statusColors[$user->status] ?? 'border-gray-400';
          @endphp

          <img
            alt="User avatar"
            class="w-10 h-10 sm:w-10 sm:h-10 rounded-full border {{ $borderClass }} border-[3px] p-[2px] object-cover"
            src="{{ $user->foto}}" />


          <p class="font-bold text-sm sm:flex pr-3 hidden">
            Hi, 
          
               {{ $user->nama }}
      
          </p>
          @endif

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
            <a href="aset" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">Aset</a>
            <a href="{{ route('user.peminjaman.index')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">Riwayat</a>
            
            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="hidden">

            </form>

            <a href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Logout
            </a>





          </div>
        </div>
      </div>
    </header>


    <!-- Navigation -->
    <div class="flex justify-center">
      <header

        class="flex hidden sm:flex justify-center -translate-y-6">
        <nav class="flex justify-center gap-[1.6rem] text-[13px] text-black w-full">
          <a class="hover:underline" href="#">Hutan</a>
          <a class="hover:underline" href="#">Kebun</a>
          <a class="hover:underline" href="#">Tambang dan Energi</a>
          <a class="hover:underline" href="#">Hukum</a>
          <a class="hover:underline" href="#">Novel</a>
          <a class="hover:underline" href="#">Lainnya</a>
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
    class="fixed inset-0  z-[199999999] pl-119 mt-2 pr-102 flex items-start justify-start pt-21">
    <div class="bg-white border border-gray-300 shadow-lg w-full max-w-7xl py-8 px-8 mx-4">
      <div class="flex flex-col space-y-8 mb-2">
        <div>
          <p class="font-bold text-sm leading-tight ">Hukum</p>

        </div>
        <div>
          <p class="font-bold text-sm leading-tight ">Hutan</p>

        </div>
        <div>
          <p class="font-bold text-sm leading-tight ">Kebun</p>

        </div>
        <div>
          <p class="font-bold text-sm leading-tight ">Tambang dan Energi</p>

        </div>
        <div>
          <p class="font-bold text-sm leading-tight">Novel</p>

        </div>
        <div>
          <p class="font-bold text-sm leading-tight ">Lainnya</p>

        </div>
      </div>
    </div>
  </div>
  <!--navbar-->


  <!--content-->
  <div>
    <div>
      @yield('content')
    </div>
  </div>

  <!--footer-->
  <footer class="border-t border-red-600 mt-auto bg-white poppins-regular">
    <div class="flex flex-col sm:flex-row items-start sm:items-center lg:px-44 px-2 py-4 border-b-2 border-black">
      <div class="mx-auto sm:mx-0 lg:mt-0 sm:w-auto">
        <img alt="Auriga company logo in gray background with white text, rectangular shape with stylized text Auriga Nusantara" class="sm:w-24 sm:h-12" height="64" src="{{asset('storage/foto/Logo Auriga.png') }}" width="96" />
      </div>
      <div class="grid grid-cols-2 sm:flex flex-wrap sm:gap-x-22 gap-x-6 gap-y-2 text-xs text-black px-4 sm:px-12 lg:px-36 w-full justify-start mt-4 text-left">
        <p class="font-semibold">Hutan</p>
        <p class="font-semibold">Kebun</p>
        <p class="font-semibold">Tambang dan Energi</p>
        <p class="font-semibold">Hukum</p>
        <p class="font-semibold">Novel</p>
        <p class="font-semibold">Lainnya</p>
      </div>



    </div>
    <div class="max-w-7xl mx-auto px-6 sm:px-36 pb-1 text-center text-[12.5px] text-black select-none">
      COPYRIGHT © 2025 AURIGA NUSANTARA. ALL RIGHTS RESERVED.
    </div>
    <div class="bg-[#1a3a05] text-white text-xs font-semibold flex justify-end px-6 sm:px-36 py-2">
    </div>
  </footer>
  @livewireScripts
</body>

</html>