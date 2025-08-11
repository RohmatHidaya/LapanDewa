<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions History') }}
        </h2>
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-data="{ tab: 'transaction' }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-center gap-x-4 ">
                    <div class="">
                        <button @click="tab = 'transaction'"  :class="tab === 'transaction' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded">Transaction</button>
                    </div>
                    <div>
                        <button @click="tab = 'kasbon'"  :class="tab === 'kasbon' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded">kasbon</button>
                    </div>
                </div>
                <div class="p-6 text-gray-900">
                    <template x-if="tab === 'kasbon'">
                        <div>
                            @include('transaction.partials.table-kasbon')
                        </div>
                    </template>

                    <template x-if="tab === 'transaction'">
                        <div>
                            @include('transaction.partials.table-transaction')
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
