<form method="post" action="{{ route('kasir.add') }}" class="mt-6 mb-3 space-y-6">
    @csrf

    <div>
        <x-input-label for="barcode" :value="__('Barcode Product')" />
        <x-autocomplete-input
            name="barcode"
            :endpoint="route('produk.autocomplete')"
            placeholder="Ketik nama atau barcode"
            :submitOnSelect="true"
            valueKey="barcode"
            labelKey="nama"
            metaKey="meta"
            descriptionKey="description"
            inputClass="mt-1 w-fit sm:w-72 border rounded px-3 py-2"
        />
    </div>
</form>
