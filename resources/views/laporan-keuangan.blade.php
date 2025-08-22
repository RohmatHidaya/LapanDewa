<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekap kas') }}
        </h2>
        <div class="pt-3">
            <a href="{{ route('laporan-keuangan.pemasukanHarian') }}">
                <x-primary-button>Buat Laporan Penjualan Hari ini</x-primary-button>
            </a>
            <x-primary-button x-data @click="$dispatch('open-modal', 'create-laporan')">
                Buat Laporan
            </x-primary-button>
        </div>
    </x-slot>

    <x-status-notif type="error" :message="session('error')" />
    @include('laporanKeuangan.create-laporan')
    <x-status-notif type="succes" :message="session('success')" />


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @include('laporanKeuangan.table-laporan-keuangan')
                    {{ $laporanKeuangan->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
