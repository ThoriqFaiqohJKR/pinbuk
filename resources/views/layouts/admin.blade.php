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


  <div class="w-full sticky top-0 bg-white">

    <div class="bg-[#1a3a05] text-white text-xs font-semibold flex justify-end py-2 px-6 sm:px-6 md:px-10 lg:px-20 xl:px-46">

    </div>
    @php
    use Illuminate\Support\Facades\DB;
    $userId = session('user_id');
    $user = $userId ? DB::table('pengguna')->where('id', $userId)->first() : null;
    @endphp


    <div class="flex items-center py-2 px-2 sm:px-6 md:px-10 lg:px-20 xl:px-40 justify-between">
      <!-- Kiri: Logo + Navigasi -->
      <div class="flex items-center gap-4 sm:gap-8 md:gap-14 lg:gap-20 xl:gap-34">
        <!-- Logo -->
        <div class="w-16 h-12 sm:w-20 sm:h-14 lg:w-24 lg:h-16 flex items-center justify-center">
          <img alt="Auriga company logo in gray background with white text, rectangular shape with stylized text Auriga Nusantara" src="{{asset('foto/Logo Auriga.png') }}" class="w-full h-full object-contain" />
        </div>


      </div>
      <div>
        <div class="flex gap-x-2  ml-6 sm:gap-x-2 md:gap-x-6 lg:gap-x-12 xl:gap-x-20 2xl:gap-x-22 text-xs sm:text-xs md:text-sm lg:text-sm xl:text-md 2xl:text-md">
          <a class="hover:font-semibold" href="/admin/users">Pengguna</a>
          <a class="hover:font-semibold" href="/admin/buku">Buku</a>
          <a class="hover:font-semibold" href="/admin/aset">Aset</a>
          <a class="hover:font-semibold" href="/admin/peminjaman">Riwayat</a>
        </div>
      </div>


      <!-- Kanan: Avatar -->
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
          class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 lg:w-10 lg:h-10 rounded-full border-3 {{ $borderClass }} object-cover"
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
        <div
          x-show="dropdownOpen"
          @click.away="dropdownOpen = false"
          class="absolute right-0 top-full mt-2 w-34 bg-white border border-gray-300 z-50 shadow-md"
          x-transition>


          <a href="/admin/users" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">Pengguna</a>
          <a href="/admin/buku" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">buku</a>
          <a href="/admin/aset" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">aset</a>
          <a href="{{ route('user.peminjaman.index')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700">Riwayat</a>

          <form id="logout-form" method="POST" action="{{ route('admin.logout') }}">
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
    <div class="border-b border-red-500 mt-1"></div>
    <!---menu-->

  </div>
  <!--navbar-->


  <!--content-->

  <div>
    @yield('content')
  </div>

  <!--footer-->
  <footer class="border-t border-red-600 mt-auto bg-white poppins-regular">
    <div class="flex flex-col sm:flex-row items-start sm:items-center px-4 sm:px-8 md:px-10 lg:px-22 xl:px-18 2xl:px-38 py-4 border-b-2 border-black">
      <div class="mx-auto sm:mx-0">
        <img alt="Auriga company logo in gray background with white text, rectangular shape with stylized text Auriga Nusantara" src="{{asset('storage/foto/Logo Auriga.png') }}" class="w-24 h-12 object-contain" />
      </div>
      <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 lg:flex flex-wrap gap-x-6 md:gap-x-4 lg:gap-x-16 xl:gap-x-22 2xl:gap-x-20 gap-y-2 text-xs text-black px-4 sm:px-8 md:px-24 lg:px-38 xl:px-80 2xl:px-80 w-full justify-start mt-4 text-left">

        <p class="font-semibold">Pengguna</p>
        <p class="font-semibold">Buku</p>
        <p class="font-semibold">Aset</p>
        <p class="font-semibold">Riwayat</p>

      </div>




    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-8 md:px-12 lg:px-20 xl:px-36 pb-1 text-center text-[11px] sm:text-[12px] md:text-[11px] lg:text-[12px] xl:text-[13px] text-black select-none">
      COPYRIGHT © 2025 AURIGA NUSANTARA. ALL RIGHTS RESERVED.
    </div>
    <div class="bg-[#1a3a05] text-white text-xs font-semibold flex justify-end px-6 sm:px-36 py-2">
    </div>
  </footer>
  @livewireScripts
</body>

</html>