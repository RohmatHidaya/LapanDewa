<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-secondary">Product lists</h6>
                        <a href="" class="btn btn-secondary mt-3" 
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'create-product')">
                            <span class="text">Add Product</span>
                        </a>
                        @include('product.partials.create-product-form')
                    </div>
                    <x-status-notif type="success" :message="session('status')" />
                    <x-status-notif type="error" :message="session('destroy')" />
                    <x-tables>
                        <x-slot name="thead">
                            <th>Nama</th>
                            <th>Harga(Rp)</th>
                            <th>Stok</th>
                            <th>Barcode</th>
                            <th>Expired</th>
                            <th>Action</th>
                        </x-slot>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->nama }}</td>
                                <td>{{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td>{{ $product->stok }}</td>
                                <td>{{ $product->barcode }}</td>
                                <td>{{ $product->expired }}</td>
                                <td>
                                <a href="{{ route('product.edit', $product->id) }}" class="text-blue-600 hover:underline">edit</a>
                                <x-delete-button :action="route('product.destroy', $product->id)" message="Yakin Hapus Produk ini?" />
                                </td>
                            </tr>
                            @endforeach
                    </x-tables>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
