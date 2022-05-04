<nav class="flex items-center justify-between flex-wrap p-6 mb-6 shadow">
    {{-- <div class="block lg:hidden">
        <button class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white">
            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
        </button>
    </div> --}}
    <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
        <div class="flex text-lg font-bold">
            <a href="/" class="px-2">
                Home
            </a>

            <a href="/cart" class="px-2">
                {{-- <svg class="text-gray-500 w-7 h-7 hover:text-black"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg> --}}
                @livewire('cart-item-count')
                {{-- </span> --}}
                Cart
            </a>
            @if (Auth::check())
                {{-- <a href="/cart" class="px-2">
                    Dashboard
                </a> --}}
                <a href="/products" class="px-2">
                    Products
                </a>
                <form class="text-lg font-bold" method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-jet-dropdown-link href="{{ route('logout') }}"
                                @click.prevent="$root.submit();">
                        {{ __('Logout') }}
                    </x-jet-dropdown-link>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-2">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-2">
                    Sign Up
                </a>
            @endif
        </div>
    </div>
</nav>
