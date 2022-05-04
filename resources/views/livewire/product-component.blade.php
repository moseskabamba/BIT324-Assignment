<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="px-4 py-4 -mx-4 space-y-4 overflow-x-auto sm:-mx-8 sm:px-8">
                <div class="flex flex-row justify-between w-full mb-1 sm:mb-0">
                    <div class="flex items-center w-2/4 space-x-4">
                        <div class="w-2/3">
                            <x-jet-input type="text" wire:model="search" placeholder="Search"></x-jet-input>
                        </div>
                    </div>
                    <div class="">
                        <x-jet-button class=" bg-primary" wire:click="addProduct">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </x-jet-button>
                    </div>
                </div>

                <div class="flex-col space-y-4">
                    <x-table>
                        <x-slot name="head">
                            <x-table.heading wire:click="sortBy('name')" sortable
                                :direction="$sortField === 'name' ? $sortDirection : null">
                                Name
                            </x-table.heading>

                            <x-table.heading wire:click="sortBy('name')" sortable
                                :direction="$sortField === 'name' ? $sortDirection : null">
                                Price
                            </x-table.heading>

                            <x-table.heading wire:click="sortBy('name')" sortable
                                :direction="$sortField === 'name' ? $sortDirection : null">
                                Quantity
                            </x-table.heading>

                            <x-table.heading wire:click="sortBy('created_at')" sortable
                                :direction="$sortField === 'created_at' ? $sortDirection : null">
                                Created at
                            </x-table.heading>

                            <x-table.heading class="flex justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </x-table.heading>
                        </x-slot>
                        <x-slot name="body">
                            @forelse ($products as $product)
                                <x-table.row wire:loading.class.delay="opacity-50">
                                    <x-table.cell>
                                        {{ $product->name }}
                                    </x-table.cell>

                                     <x-table.cell>
                                        {{ $product->price }}
                                    </x-table.cell>

                                     <x-table.cell>
                                        {{ $product->quantity }}
                                    </x-table.cell>

                                    <x-table.cell>
                                        {{ \Carbon\Carbon::parse($product->created_at)->diffForHumans() }}
                                    </x-table.cell>
                                    <x-table.cell class="flex items-center justify-end py-2 space-x-2">
                                        {{-- @if ($role->id != auth()->id()) --}}
                                        <x-button.edit wire:click='edit({{ $product->id }})' />

                                        {{-- <x-button.delete wire:click="startDelete({{ $role->id }})"/> --}}
                                        {{-- @endif --}}
                                    </x-table.cell>
                                </x-table.row>
                            @empty
                                <x-table.row>
                                    <x-table.cell colspan="6">
                                        <div class="flex items-center justify-center">
                                            <span class="py-4 text-lg text-gray-400">
                                                No Product Found
                                            </span>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                            @endforelse
                        </x-slot>
                    </x-table>
                    <div class="">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Add --}}
        <x-jet-dialog-modal wire:model.defer="showForm">
            <x-slot name="title">
                <div class="relative mt-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300">
                        </div>
                    </div>
                    <div class="relative flex justify-center text-sm leading-5">
                        <span class="px-2 font-bold text-gray-500 bg-white">
                            {{ __('Add a Product') }}
                        </span>
                    </div>
                </div>
            </x-slot>

            <x-slot name="content">
                <div class="grid grid-cols-1 gap-6 ">

                    <div class="w-full">
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input type="text" id="name" wire:model.lazy="product.name" />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>

                    <div class="w-full">
                        <x-jet-label for="name" value="{{ __('Price') }}" />
                        <x-jet-input type="text" id="price" wire:model.lazy="product.price" />
                        <x-jet-input-error for="price" class="mt-2" />
                    </div>

                    <div class="w-full">
                        <x-jet-label for="name" value="{{ __('Quantity') }}" />
                        <x-jet-input type="text" id="quantity" wire:model.lazy="product.quantity" />
                        <x-jet-input-error for="quantity" class="mt-2" />
                    </div>

                    <div class="mb-2">
                    {{-- <div class="md:w-1/2 w-full">
                                <x-jet-input class="text-xs" type="file" wire:model="brochure_array.file" />
                                <!-- Progress Bar -->
                                <div x-show="isUploading">
                                    <progress class="h-2" max="100" x-bind:value="progress"></progress>
                                </div>
                            </div> --}}
                    <div class="flex" x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <div class="w-1/2 mb-2">
                            <div class="flex">
                                <x-jet-label class="w-auto" for="image" value="{{ __('Product Image') }}" /><span class="w-auto ml-1 text-red-700 text-danger"> * </span>
                                <x-jet-input-error for="image" />
                            </div>
                            <label class="w-auto text-xs" for="image">Max File Size: 5Mb</label>
                        </div>
                        <div class="w-1/2 ml-4">
                            <input class="text-xs" type="file" wire:model="image" />
                            <!-- Progress Bar -->
                            <div x-show="isUploading">
                                <progress class="h-2" max="100" x-bind:value="progress"></progress>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="clearStates" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="saveProduct" wire:loading.attr="disabled">
                    {{ __('Save ') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>


        <x-jet-confirmation-modal class="w-64" wire:model="deleteForm">
            <x-slot name="title">
                {{ __('Delete ') }}
            </x-slot>

            <x-slot name="content">
                {!! __('Are you sure you want to delete this <b class="uppercase">' . $product->name . '</b> ?') !!}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click='clearStates' wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Delete ') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
    </div>
</div>
