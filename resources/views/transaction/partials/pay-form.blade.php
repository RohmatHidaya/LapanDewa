@if (session('modalPayForm'))
    <x-modal name="pay-form" :show="true" focusable maxWidth="md">
        <form method="POST" action="{{ route('transaksi.payOffKasbon', $transaction->id) }}" class="m-3" >
            @method('patch')
            @csrf

            <h2 class="text-lg font-medium text-gray-900 text-center">
                {{ __('Form Pembayaran Kasbon') }}
            </h2>

            <div class="mt-6">
                <x-input-rupiah name="payment" placeholder="Cth10000" label="Uang Diterima" />
                <x-input-error class="mt-2" :messages="$errors->get('payment')" />
            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Bayar') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
@endif