<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  </script>
  <title>
    Dashboard
  </title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>@yield('title', 'Dashboard')</title>
  <style>
    .active {
      border-bottom: 4px solid white;
      color: white;
    }
  </style>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles

</head>

<body class="font-roboto bg-gray-100">
  <nav class="bg-green-600 shadow-md fixed top-0 left-0 w-full z-50" x-data="{ open: false }">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center sm:hidden">
          <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400  hover:bg-black focus:outline-none focus:bg-gray-100 focus:text-gray-500">
            <i>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 text-white ">
                <path fill-rule="evenodd" d="M2 3.75A.75.75 0 0 1 2.75 3h10.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 3.75ZM2 8a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 8Zm0 4.25a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
              </svg>

            </i>
          </button>
        </div>
        <div class="flex">
          <div class="hidden sm:flex">
            <a class="nav-link text-white hover:text-black inline-flex items-center px-4 pt-1 pb-2 text-sm font-medium hover:bg-white" href="/admin/dashboard">
              Home
            </a>
            <a class="nav-link text-white hover:text-gray-800 inline-flex items-center px-4 pt-1 pb-2 text-sm font-medium hover:bg-white" href="/admin/users">
              Pengguna
            </a>
            <a class="nav-link text-white hover:text-gray-800 inline-flex items-center px-4 pt-1 pb-2 text-sm font-medium hover:bg-white" href="/admin/buku">
              Buku
            </a>
            <a class="nav-link text-white hover:text-gray-800 inline-flex items-center px-4 pt-1 pb-2 text-sm font-medium hover:bg-white" href="/admin/asset">
              Aset
            </a>
            <a class="nav-link text-white hover:text-gray-800 inline-flex items-center px-4 pt-1 pb-2 text-sm font-medium hover:bg-white" href="/admin/contact">
              Kontak
            </a>
            <a class="nav-link text-white hover:text-gray-800 inline-flex items-center px-4 pt-1 pb-2 text-sm font-medium hover:bg-white" href="/admin/peminjaman">
              Peminjaman
            </a>
          </div>
        </div>
        <div class="hidden sm:flex items-center">
          <div x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center space-x-2 text-white">
              <img alt="Profile" class="h-10 w-10 rounded-full" height="100" src="https://storage.googleapis.com/a1aa/image/AhSJm8Uq1QmnYb-xcclrcWQ5R_e3gJpRZgrO6cizf8M.jpg" width="100" />
              <i class="fas fa-chevron-down">
              </i>
            </button>
            <div x-cloak @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white shadow-lg py-1" x-show="open">
            <a class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100" href="{{ url('admin/logout') }}">
                Log Out
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div @click.away="open = false" class="fixed inset-y-0 left-0 w-64 bg-white z-50 sm:hidden" x-show="open" x-transition:enter="transition transform ease-out duration-300" x-transition:enter-end="translate-x-0" x-transition:enter-start="-translate-x-full" x-transition:leave="transition transform ease-in duration-300" x-transition:leave-end="-translate-x-full" x-transition:leave-start="translate-x-0">
      <div class="h-full transform transition-all duration-300 overflow-y-auto">
        <div class="pt-2 pb-3 space-y-1">
          <a class="bg-indigo-50 border-indigo-500 text-indigo-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium hover:bg-indigo-100" href="/admin/dashboard">
            Home
          </a>
          <a class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium hover:bg-indigo-100" href="/admin/users">
            Pengguna
          </a>
          <a class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium hover:bg-indigo-100" href="#">
            Buku
          </a>
          <a class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium hover:bg-indigo-100" href="#">
            Aset
          </a>
          <a class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium hover:bg-indigo-100" href="#">
            Kontak
          </a>
          <a class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium hover:bg-indigo-100" href="#">
            Peminjaman
          </a>
          <hr class="border-gray-300" />
          <a class="border-transparent text-red-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium hover:bg-indigo-100" href="/logout">
            Log Out
          </a>
        </div>
      </div>
    </div>
  </nav>
  <div class="flex pt-16">
    <div class="flex-1">
      @yield('content')
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      let links = document.querySelectorAll(".nav-link");
      links.forEach(link => {
        if (link.href === window.location.href) {
          link.classList.add("active");
        }
      });
    });
  </script>
  @livewireScripts
</body>

</html>