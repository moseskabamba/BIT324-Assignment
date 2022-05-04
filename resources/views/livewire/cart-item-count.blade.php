<div class="">
    @if( is_array($cart) && count($cart) > 0)
        <span class="absolute w-5 font-sans text-sm text-center text-white align-middle bg-orange-500 rounded-full shadow-sm hover:bg-orange-600 left-3 bottom-3 text-bold">
            {{ count($cart) }}
        </span>
    @endif
</div>
