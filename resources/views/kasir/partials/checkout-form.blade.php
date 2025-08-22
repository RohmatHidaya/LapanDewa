 <h1 class="text-3xl">Total Rp.{{ number_format($total, 0 , ',' , '.' ) }}</h1>
<form method="POST" action="{{ route('kasir.checkout') }}">
    @csrf
    <div>

        <x-input-rupiah name="paid_amount" placeholder="Cth: 100000" label="Bayar" class="mt-1 w-fit" />

        <x-primary-button class="">
            {{ __('Bayar') }}
        </x-primary-button>
    </div>
</form>