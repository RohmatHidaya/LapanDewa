<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kasir') }}
        </h2>
        <div class="pt-3">
            <a href="{{ route('laporan-keuangan.pemasukanHarian') }}">
                <x-primary-button>Buat Laporan Penjualan Hari ini</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col md:flex-row justify-between items-start p-4 text-gray-900">
                    <x-status-notif type="error" :message="session('error')" />
                    <div class="p-2 w-full md:w-1/2 text-gray-900">
                        @include('kasir.partials.add-product-form')
                        @include('kasir.partials.cart')
                    </div>
                </div>
                <div class="mt-6 space-y-6 w-full md:w-1/2 overflow-x-auto text-gray-900 p-4">
                   @include('kasir.partials.checkout-form')
                </div>
                @include('kasir.partials.transaction-succes-detail')
            </div>
        </div>
    </div>
</x-app-layout>
