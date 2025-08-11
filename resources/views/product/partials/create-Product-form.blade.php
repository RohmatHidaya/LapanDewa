
<x-modal name="create-product" :show="$errors->any()" focusable>
        <form method="post" action="{{ route('product.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Create New Product') }}
            </h2>

            <div class="mt-6">
                <x-input-label for="name" :value="__('Name')" />

                <x-text-input
                    id="name"
                    name="nama"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Product Name') }}"
                    :value="old('nama')"
                    required
                />

            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
            </div>
            
            <div class="mt-6">
                <x-input-label for="Harga" :value="__('Harga')" />

                <x-text-input
                    id="harga"
                    name="harga"
                    type="number"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Harga Product') }}"
                    :value="old('harga')"
                    required
                />

            <x-input-error class="mt-2" :messages="$errors->get('harga')" />
            </div>

            <div class="mt-6">
                <x-input-label for="stok" :value="__('Product Stok')" />

                <x-text-input
                    id="stok"
                    name="stok"
                    type="number"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Stok') }}"
                    :value="old('stok')"
                    required
                />
            
                <x-input-error :messages="$errors->get('stok')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="barcode" :value="__('Product Barcode')" />

                <x-text-input
                    id="barcode"
                    name="barcode"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('barcode') }}"
                    :value="old('barcode')"
                    required
                />
            
                <x-input-error :messages="$errors->get('barcode')" class="mt-2" />
            </div>

            

            <div class="mt-6">
                <x-input-label for="expired" :value="__('Product Expired')" />

                <x-text-input
                    id="expired"
                    name="expired"
                    type="date"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Expired Date') }}"
                    :value="old('expired')"
                    required
                />

                <x-input-error :messages="$errors->get('expired')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Create User') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>