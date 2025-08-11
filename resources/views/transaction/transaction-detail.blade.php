<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('transaksi') }}">&larr;</a> #{{ $transaction->invoice_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                     <div class="max-w-5xl mx-auto p-6 bg-white shadow rounded-lg">
                        @include('transaction.partials.pay-form')
        <div class="grid grid-cols-2 gap-6 border-b pb-4 mb-4">
            <div>
                <h3 class="text-lg font-semibold">Detail Transaksi</h3>
                <p><span class="font-medium">Tipe Pembayaran:</span> 
                    <span class="{{ $transaction->status == 'on_credit' ? 'text-red-500' : 'text-green-500' }}">{{ $transaction->status == 'on_credit' ? 'Belum Lunas' : 'Lunas' }}</span></p>
                <p><span class="font-medium">Nama Pegawai:</span> {{ $transaction->user->name }}</p>
                <p><span class="font-medium">Tanggal Transaksi:</span> {{ $transaction->created_at->format('d M Y, H:i') }}</p>
                {{-- <p><span class="font-medium">Nama Pelanggan:</span> {{ $transaction->customer_name }}</p> --}}
            </div>

            <div class="flex flex-col items-end justify-start space-y-2">
                <x-secondary-button>Kirim Struk</x-secondary-button>
                <x-secondary-button>Cetak Struk</x-secondary-button>

                <form action="{{ route('transaksi.showPayForm', $transaction->id) }}" method="post">
                    @csrf
                    <x-primary-button class="mt-2">
                        Bayar
                    </x-primary-button>
                </form>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold mb-2">Detail Pembelian</h3>
            <table class="w-full border rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-2">Produk</th>
                        <th class="text-right p-2">Harga</th>
                        <th class="text-right p-2">Quantity</th>
                        <th class="text-right p-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->detail as $item)
                    <tr class="border-t">
                        <td class="p-2">{{ $item->product->nama }}</td>
                        <td class="text-right p-2">Rp{{ number_format($item->price) }}</td>
                        <td class="text-right p-2">{{ $item->quantity }}</td>
                        <td class="text-right p-2">Rp{{ number_format($item->price * $item->quantity) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right mt-4 space-y-1">
                <p><span class="font-medium">Total:</span> <strong>Rp{{ number_format($transaction->total_price) }}</strong></p>
                <p><span class="font-medium">Bayar:</span> <strong>Rp{{ number_format($transaction->paid_amount) }}</strong></p>
                <p><span class="font-medium">Kembalian:</span> <strong>Rp{{ number_format($transaction->change_amount) }}</strong></p>
                @if ($transaction->due_amount > 0)
                    <p><span class="font-medium text-red-600">Sisa Kasbon:</span> Rp{{ number_format($transaction->due_amount) }}</p>
                @endif
            </div>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>