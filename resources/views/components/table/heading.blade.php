@props([
    'sortable' => null,
    'direction' => null,
])

<th {{ $attributes->merge(['class' => 'px-6 py-3 bg-gray-200'])->only('class') }}>
    @unless($sortable)
        <span class="flex text-xs font-bold leading-4 text-gray-700 uppercase">
            {{ $slot }}
        </span>
    @else
        <button {{ $attributes->except('class') }} class="flex items-center space-x-1 text-xs font-medium leading-4">
            <span>{{ $slot }}</span>
            <span>
                @if ($direction === 'asc')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                @elseif ($direction === 'desc')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                @endif
            </span>
        </button>
    @endunless
</th>
