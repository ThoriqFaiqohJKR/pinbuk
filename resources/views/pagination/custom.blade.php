@if ($paginator->hasPages())
<nav class="flex items-center justify-center">
    <!-- Tombol Previous -->
    @if ($paginator->onFirstPage())
    <span class="px-3 py-2 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
        </svg>



    </span>
    @else
    <button wire:click="previousPage" class="px-3 py-2 hover:text-blue-600">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
        </svg>
    </button>
    @endif

    <!-- Nomor Halaman -->
    @foreach ($elements as $element)
    @if (is_string($element))
    <span class="px-3 py-2 text-gray-400">{{ $element }}</span>
    @endif

    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <span class="px-2 py-1 bg-auriga text-white rounded-full text-center text-xs">{{ $page }}</span>
    @else
    <button wire:click="gotoPage({{ $page }})" class="px-4 py-2 hover:text-blue-600">{{ $page }}</button>
    @endif
    @endforeach
    @endif
    @endforeach

    <!-- Tombol Next -->
    @if ($paginator->hasMorePages())
    <button wire:click="nextPage" class="px-3 py-2 hover:text-blue-600">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
        </svg>

    </button>
    @else
    <span class="px-3 py-2 text-gray-400">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
        </svg>

    </span>
    @endif
</nav>
@endif