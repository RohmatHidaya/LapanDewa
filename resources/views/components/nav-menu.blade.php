<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
{{ __('Dashboard') }}
</x-nav-link>

<x-nav-link :href="route('kasir')" :active="request()->routeIs('kasir')">
{{ __('Kasir') }}
</x-nav-link>

<x-nav-link :href="route('produk')" :active="request()->routeIs('produk')">
{{ __('Produk') }}
</x-nav-link>

<x-nav-link :href="route('transaksi')" :active="request()->routeIs('transaksi')">
{{ __('Transaksi') }}
</x-nav-link>

<x-nav-link :href="route('user')" :active="request()->routeIs('user')">
{{ __('Users') }}
</x-nav-link>