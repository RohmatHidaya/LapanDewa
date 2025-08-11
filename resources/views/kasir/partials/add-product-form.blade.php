<form method="post" action="{{ route('kasir.add') }}" class="mt-6 mb-3 space-y-6">
    @csrf

    <div>
        <x-input-label for="barcode" :value="__('Barcode Product')" />
        <x-text-input id="barcode" name="barcode" type="text" class="mt-1 w-fit"  required autofocus autocomplete="name" />
    </div>
</form>