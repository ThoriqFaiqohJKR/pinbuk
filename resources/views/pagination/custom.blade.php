@if ($paginator->hasPages())
    <nav class="flex items-center justify-center space-x-2">
        <!-- Tombol Previous -->
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-gray-400">&lt;</span>
        @else
            <button wire:click="previousPage" class="px-3 py-2 hover:text-gray-600">&lt;</button>
        @endif

        <!-- Nomor Halaman -->
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-2 text-gray-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-4 py-2 bg-green-500 text-white rounded-md text-center">{{ $page }}</span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" class="px-4 py-2 hover:text-gray-600">{{ $page }}</button>
                    @endif
                @endforeach
            @endif
        @endforeach

        <!-- Tombol Next -->
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" class="px-3 py-2 hover:text-gray-600">&gt;</button>
        @else
            <span class="px-3 py-2 text-gray-400">&gt;</span>
        @endif
    </nav>
@endif
