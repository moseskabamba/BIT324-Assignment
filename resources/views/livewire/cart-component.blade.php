<div>
    <div>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ auth()->user()->name ?? ''}}'s Cart
            </h2>
        </x-slot>
    </div>
    @if(session('message'))
        <div class="bg-red-500 dark:bg-gray-800">
            <div class="px-3 py-3 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="flex items-center flex-1 w-0">
                        <span class="flex p-2 bg-red-500 rounded-lg dark:bg-black">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="w-6 h-6 text-white" viewBox="0 0 1792 1792">
                                <path d="M1024 1375v-190q0-14-9.5-23.5t-22.5-9.5h-192q-13 0-22.5 9.5t-9.5 23.5v190q0 14 9.5 23.5t22.5 9.5h192q13 0 22.5-9.5t9.5-23.5zm-2-374l18-459q0-12-10-19-13-11-24-11h-220q-11 0-24 11-10 7-10 21l17 457q0 10 10 16.5t24 6.5h185q14 0 23.5-6.5t10.5-16.5zm-14-934l768 1408q35 63-2 126-17 29-46.5 46t-63.5 17h-1536q-34 0-63.5-17t-46.5-46q-37-63-2-126l768-1408q17-31 47-49t65-18 65 18 47 49z">
                                </path>
                            </svg>
                        </span>
                        <p class="ml-3 font-medium text-white truncate">
                            <span class="">
                                {{ session('message') }}
                            </span>
                        </p>
                    </div>
                    {{--  <div class="flex-shrink-0 order-3 w-full mt-2 sm:order-2 sm:mt-0 sm:w-auto">
                        <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-green-500 bg-white border border-transparent rounded-md shadow-sm dark:text-gray-800 hover:bg-green-50">
                            Add Branding
                        </a>
                    </div>  --}}
                </div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="px-2 mx-auto md:w-3/4">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                {{-- Desktop view table --}}
                <div id="desktop-view" class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden border-b border-gray-200 shadow">
                            @if($cart)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-orange-500">
                                        <th scope="col" class="px-6 py-3 font-medium tracking-wider text-left text-black bg-white">
                                            Product
                                        </th>
                                        <th scope="col" class="px-6 py-3 font-medium tracking-wider text-left text-black bg-white">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3 font-medium tracking-wider text-left text-black bg-white">
                                            Unit Price
                                        </th>
                                        <th scope="col" class="px-6 py-3 font-medium tracking-wider text-left text-black bg-white">
                                            Quantity
                                        </th>
                                        <th scope="col" class="px-6 py-3 font-medium tracking-wider text-left text-black bg-white">
                                            Total
                                        </th>
                                        <th scope="col" class="float-right px-6 py-3 font-medium tracking-wider text-black uppercase bg-white">
                                            <svg class="w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cart as $key=>$cartItem)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 w-24 h-24">
                                                        <img class="" src="{{ asset($cartItem['product']['image'] ?? $cartItem['image'] ?? '') }}" alt="">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $cartItem['product']['name'] ?? $cartItem['name'] ?? 'Product Name' }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                               <span> {{ $cartItem['product']['price'] ?? $cartItem['price'] ?? 0 }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-48 h-13 custom-number-input">
                                                        <div class="relative flex flex-row w-full bg-transparent border border-2 border-gray-200 h-13">
                                                            <button data-action="decrement" class="w-20 h-full text-black bg-white outline-none cursor-pointer focus:outline-none hover:text-red-400 hover:bg-red-700">
                                                                <span wire:click="decrement({{ $key }})" class="m-auto text-2xl font-thin">−</span>
                                                            </button>
                                                            <input type="number" wire:keydown.debounce.1s="updatequantity({{$key}})" wire:model="cart.{{ $key }}.quantity" class="cursor-text flex items-center w-full font-semibold text-center text-orange-700 bg-white outline-none focus:outline-none text-sm hover:text-black focus:text-black md:text-sm cursor-default" name="custom-input-number" value="0"></input>
                                                            <button data-action="increment" class="w-20 h-full text-black bg-white cursor-pointer focus:outline-none hover:text-red-400 hover:bg-red-700">
                                                                <span wire:click="increment({{ $key }})" class="m-auto text-2xl font-thin">+</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ number_format($cartItem['total'], 2) ?? $cartItem['product']['price'] * $cartItem['quantity'] ?? 0 }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex items-center float-right">
                                                    <a class="px-3" wire:click="removeProductFromCart({{ $cartItem['id'] ?? $key }})" >
                                                        <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                <div class="py-32 mx-auto font-semibold text-center bg-white">
                                    Your Cart Is Empty
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Mobile view table --}}
                    <div id="mobile-view" class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden border-b border-gray-200 shadow">
                            @if($cart)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-orange-500">
                                        <th scope="col" class="px-6 py-3 font-medium tracking-wider text-left text-white bg-orange-500">
                                            Product
                                        </th>
                                        <th scope="col" class="px-1 py-1 font-medium text-left text-white bg-orange-500">
                                            Unit Price
                                        </th>
                                        <th scope="col" class="px-6 py-3 font-medium tracking-wider text-left text-white bg-orange-500">
                                            Total
                                        </th>
                                        {{-- <th scope="col" class="float-right px-6 py-3 font-medium tracking-wider text-orange-500 uppercase bg-orange-500">
                                            <svg class="w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </th> --}}
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cart as $key=>$cartItem)
                                        <tr>
                                            <td class="py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                <div class="flex items-center">
                                                    <a class="" wire:click="removeProductFromCart({{ $cartItem['id'] ?? $key }})" >
                                                        <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </a>
                                                </div>
                                                <div>
                                                    <div class="flex-shrink-0 w-24 h-24">
                                                    <div>
                                                        <img class="w-20 h-20"  src="{{ asset($cartItem['product']['image'] ?? $cartItem['image'] ?? '') }}" alt="">
                                                        <div class="overflow-x-auto">
                                                        <div class="text-lg mt-1 text-gray-900">{{ $cartItem['product']['name'] ?? $cartItem['name'] ?? 'Product Name' }}</div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                 </div>
                                                 <div>
                                                 </div>
                                                 <div class="ml-2 items-center bg-transparent  ">
                                            <button
                                            data-action="decrement"
                                            class="border rounded border-gray-200 text-orange-500 rounded bg-white outline-none cursor-pointer focus:outline-none hover:text-orange-700 hover:bg-orange-400  w-10">
                                            <span wire:click="decrement({{ $key }})" class="m-auto text-1xl font-thin">−</span>
                                          </button>
                                          <br/>
                                            <input
                                            wire:keydown.debounce.1s="updatequantity({{$key}})" wire:model="cart.{{ $key }}.quantity"
                                            type="number"
                                            class="w-10 mt-2 mb-2 font-semibold rounded text-center text-black bg-white outline-none focus:outline-none text-sm hover:text-black focus:text-black md:text-sm cursor-default"
                                            name="custom-input-number" value="0"
                                            />
                                            <br/>
                                            <button
                                            data-action="increment"
                                             class="border rounded border-gray-200 text-black bg-white cursor-pointer focus:outline-none hover:text-red-700 hover:bg-red-200 rounded
                                            font-bold text-1xl w-10">
                                             <span wire:click="increment({{ $key }})" class="m-auto text-1xl font-thin">+</span>
                                            </button>
                                            </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $cartItem['product']['price'] ?? $cartItem['price'] ?? 0 }}
                                            </td>
                                            {{-- <td class="text-sm text-center text-gray-500 whitespace-nowrap">
                                                <div class="items-center">
                                                    <div class="w-48 h-13 custom-number-input">
                                                        <div class="bg-transparentborder-gray-200 h-13">
                                                            <button data-action="decrement" class="border w-20 h-full text-orange-500 bg-white outline-none cursor-pointer focus:outline-none hover:text-orange-700 hover:bg-orange-400">
                                                                <span wire:click="decrement({{ $key }})" class="m-auto text-2xl font-thin">−</span>
                                                            </button>
                                                            <input type="number" wire:keydown.debounce.1s="updatequantity({{$key}})" wire:model="cart.{{ $key }}.quantity" class="cursor-text flex items-center w-full font-semibold text-center text-orange-700 bg-white outline-none focus:outline-none text-sm hover:text-black focus:text-black md:text-sm cursor-default" name="custom-input-number" value="0"></input>
                                                            <button data-action="increment" class="border w-20 h-full text-orange-500 bg-white cursor-pointer focus:outline-none hover:text-orange-700 hover:bg-orange-400">
                                                                <span wire:click="increment({{ $key }})" class="m-auto text-2xl font-thin">+</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td> --}}
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ number_format($cartItem['total'], 2) ?? $cartItem['product']['price'] * $cartItem['quantity'] ?? 0 }}
                                            </td>
                                            {{-- <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex items-center float-right">
                                                    <a class="px-3" wire:click="removeProductFromCart({{ $cartItem['id'] ?? $key }})" >
                                                        <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                <div class="py-32 mx-auto font-semibold text-center bg-white">
                                    Cart Is Empty
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-10">
                @if($cart)
                    <div class="flex flex-col space-x-2 md:flex-row">
                        <x-jet-secondary-button  wire:click="clearCart">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>Clear Cart</span>
                        </x-jet-secondary-button>
                        {{-- <a href="{{ route('checkout') }}" class="inline-flex items-center px-10 py-5 bg-orange-500 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 active:bg-orange-900 focus:outline-none focus:border-orange-900 focus:shadow-outline-orange disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Checkout</span>
                        </a> --}}
                        <x-jet-secondary-button  wire:click="downloadQuotation">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>Download Quotation</span>
                        </x-jet-secondary-button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<style scoped>

@media only screen and (max-width: 900px) {
  #desktop-view {
   display:none;
  }
}
@media only screen and (min-width: 901px) {

  #mobile-view{
    display:none;
}
}
</style>
