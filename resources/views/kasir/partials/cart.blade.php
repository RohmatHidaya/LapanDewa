<x-tables>
    <x-slot name="thead">
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Sub Total</th>
    </x-slot>
    @foreach ($cart as $item)
    <tr>
        <td>{{ $item['name'] }}</td>
        <td>{{ number_format($item['price'], 0, ',', '.') }}</td>
        <td>
            <form method="POST" action="{{ route('kasir.quantity', $item['id']) }}">
                @csrf
                @method('patch')
                <x-text-input id="quantity" name="quantity" type="number" class="w-12 p-0 text-center" :value="$item['quantity']"  />
            </form>
        </td>
        <td>{{ number_format($item['subtotal'], 0, ',', '.') }}</td>
        <td>
            <form method="post" action="{{ route('kasir.remove', $item['id']) }}">
                @csrf
                @method('delete')
                <button type="submit" 
                    class="bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700 transition">
                    Hapus
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</x-tables>