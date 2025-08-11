<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __("Edit Product") }}
        </h2>
    </header>

    <form method="post" action="{{ route('product.update', $product->id ) }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="nama" type="text" class="mt-1 block w-full" :value="old('name', $product->nama)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="harga" :value="__('Harga')" />
            <x-text-input id="harga" name="harga" type="number" class="mt-1 block w-full" :value="old('harga', $product->harga)" required />
            <x-input-error class="mt-2" :messages="$errors->get('harga')" />
        </div>
        
        <div>
            <x-input-label for="stok" :value="__('Stok')" />
            <x-text-input id="stok" name="stok" type="number" class="mt-1 block w-full" :value="old('stok', $product->stok)" required />
            <x-input-error class="mt-2" :messages="$errors->get('stok')" />
        </div>
        
        <div>
            <x-input-label for="barcode" :value="__('Barcode')" />
            <x-text-input id="barcode" name="barcode" type="string" class="mt-1 block w-full" :value="old('barcode', $product->barcode)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('barcode')" />
        </div>
        
        <div>
            <x-input-label for="expired" :value="__('expired')" />
            <x-text-input id="expired" name="expired" type="date" class="mt-1 block w-full" :value="old('expired', $product->expired)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('expired')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            <x-secondary-button onclick="window.history.back()">{{ __('Cancel') }}</x-secondary-button>
        </div>
    </form>
</section>
