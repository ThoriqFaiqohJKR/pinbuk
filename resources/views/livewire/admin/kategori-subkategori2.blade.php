<div>
    {{-- The whole world belongs to you. --}}
    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-40 xl:px-48 py-8">
        <!-- Breadcrumb Menu -->
        <div class="flex items-center space-x-6 select-none">
            <!-- Kategori -->
            <div
                class="flex items-center space-x-2 border border-blue-300  bg-blue-50">

                <a href="{{ url('/admin/buku/kategori-buku/' . $kategoriId) }}">
                    <div class="flex items-center space-x-2  bg-blue-50">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 text-blue-700 font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                            </svg>
                        </div>
                        <span class="text-gray-800 text-lg font-semibold truncate pr-4">
                            {{ $kategoriNama ?? 'Kategori' }}
                        </span>
                    </div>
                </a>

            </div>

            <!-- Panah -->
            <div

                aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M13.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L11.69 12 4.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M19.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06L17.69 12l-6.97-6.97a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                </svg>

            </div>

            <div
                class="flex items-center space-x-2   bg-blue-50">

                <a href="{{ url('/admin/buku/kategori-buku/'.$kategoriId.'/subkategori/'.$subkategori1Id) }}">
                    <div class="flex items-center space-x-2 border border-blue-300 bg-blue-50">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 text-blue-700 font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                            </svg>
                        </div>
                        <span class="text-gray-800 text-lg font-semibold truncate pr-4">
                            {{ $sub1Nama   }}
                        </span>
                    </div>
                </a>

            </div>

            <!-- Panah -->
            <div

                aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M13.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L11.69 12 4.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M19.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06L17.69 12l-6.97-6.97a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                </svg>

            </div>

            <div
                class="flex items-center space-x-2 border border-blue-300  bg-blue-50">


                <div class="flex items-center space-x-2 border border-blue-300 bg-blue-50">
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-100 text-blue-700 font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                        </svg>
                    </div>
                    <span class="text-gray-800 text-lg font-semibold truncate pr-4">
                        {{ $sub2Nama }}
                    </span>
                </div>


            </div>
        </div>

        <!-- Daftar Buku di Subkategori 2 -->
        <div>
            <h3 class="text-xl font-semibold py-4">📘 Buku di “{{ $sub2Nama }}”</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
                @forelse($buku as $b)
                <div class="w-56 bg-white shadow-md overflow-hidden flex flex-col">
                    <div class="p-2">
                        <img
                            alt="Book cover"
                            class="w-full h-56 object-cover bg-gray-100"
                            src="{{ $b->foto_buku ?? 'https://via.placeholder.com/224x224?text=Buku' }}" />
                    </div>
                    <div class="p-3 bg-gray-100 flex flex-col justify-between flex-grow">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2">
                                {{ $b->nama_buku }}
                            </h2>
                            <p class="text-gray-700 mb-2 text-xs line-clamp-2">
                                {{ $b->deskripsi ?? 'Deskripsi belum tersedia.' }}
                            </p>
                            <div class="flex items-center text-gray-600 text-xs mb-3">
                                <i class="fas fa-book-open mr-1"></i>
                                {{ $b->status ?? 'Tersedia' }}
                            </div>
                        </div>
                        <a href="{{ url('admin/buku/' . $b->id . '/detail') }}"
                            class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-1.5 transition text-xs mt-auto block">
                            Detail
                        </a>

                    </div>
                </div>
                @empty
                <p class="text-gray-500">Tidak ada buku di kategori ini</p>
                @endforelse
            </div>
        </div>
    </div>

</div>