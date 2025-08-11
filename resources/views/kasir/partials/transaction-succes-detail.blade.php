 @if (session('showModal'))
    <x-modal name="checkout-success" :show="true" focusable maxWidth="md">
        <div class="p-6">
            @php
                $detail = session('detail')->first();
            @endphp

            {{-- @foreach ($details as $item) --}}
                <div class="text-center">                
                    <h2 class="text-lg font-medium text-gray-900">Transaksi Berhasil</h2>
                    <p class="mt-2 text-gray-700">
                        {{ $detail->created_at->format('d-M-Y, H:i') }}
                    </p>
                    <p class="mt-4 text-gray-700 flex justify-between">
                        <span>Total Tagihan</span>
                        <span>Rp{{ number_format($detail->total_price, '0', ',', '.') }}</span>
                    </p>
                    <p class="mt-2 text-gray-700 flex justify-between">
                        <span>Uang Diterima</span>
                        <span>Rp{{ number_format($detail->paid_amount, '0', ',', '.') }}</span>
                    </p>
                    <p class="mt-2 text-gray-700 flex justify-between">
                        <span>Kembalian</span>
                        <span>Rp{{ number_format($detail->change_amount, '0', ',', '.') }}</span>
                    </p>
                </div>
            {{-- @endforeach --}}
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">ESC</x-secondary-button>
            </div>
        </div>
    </x-modal>
@endif