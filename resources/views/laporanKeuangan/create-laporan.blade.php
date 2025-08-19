<x-modal name="create-laporan" :show="$errors->any()" focusable >
    <form action="{{ route('laporan-keuangan.store') }}" method="post" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900">
                {{ __('Buat Laporan Baru') }}
        </h2>

        <div class="mt-6">
            <x-input-label :value="__('Kategori')" />
            <select name="kategori">
                <option value="">Pilih Kategori</option>
                <option value="pemasukan">Pemasukan</option>
                <option value="pengeluaran">Pengeluaran</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('kategori')" />
        </div>

        <div class="mt-6">
            <x-input-label :value="__('Keterangan')" />
            <x-text-input
                name="keterangan"
                type="text"
                class="mt-1 block w-3/4"
                placeholder="{{ __('Keterangan') }}"
                :value="old('keterangan')"
                required
            />
            <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
        </div>

        <div class="mt-6">
            <x-input-label :value="__('Jumlah')" />
            <x-text-input
                name="jumlah"
                type="number"
                class="mt-1 block w-3/4"
                placeholder="{{ __('Jumlah') }}"
                :value="old('jumlah')"
                required
            />
            <x-input-error class="mt-2" :messages="$errors->get('jumlah')" />
        </div>
        <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Buat Laporan') }}
                </x-primary-button>
        </div>
    </form>
</x-modal>