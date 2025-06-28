<div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-40 xl:px-48 py-8">
    <h2 class="text-xl font-bold mb-4">Daftar Kategori Buku</h2>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($kategoriList as $kategori)
        <a href="{{ url('/admin/buku/kategori-buku/' . $kategori->id) }}">
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition p-4 flex flex-col items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>

                <div class="text-base font-semibold text-gray-800">
                    {{ $kategori->nama }}
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>