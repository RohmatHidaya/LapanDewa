 <h1 class="text-3xl">Total Rp.{{ number_format($total, 0 , ',' , '.' ) }}</h1>
<form method="POST" action="{{ route('kasir.checkout') }}">
    @csrf
    <div>
        <x-input-label for="paid_amount" :value="__('Bayar')" />
        <x-text-input id="paid_amount" name="paid_amount" type="number" class="mt-1 w-fit"  required autofocus />
        <x-primary-button class="">
            {{ __('Bayar') }}
        </x-primary-button>
    </div>
</form>