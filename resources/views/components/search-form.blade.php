@props([
    'action' => '#',
    'placeholder' => 'Search...',
    'name' => 'q',
])

<form method="GET" action="{{ $action }}" class="mb-4">
    <div class="flex items-center gap-2">
        <input 
            type="text" 
            name="q" 
            value="{{ request($name) }}" 
            placeholder="{{ $placeholder }}" 
            class="border rounded px-3 py-2 w-fit sm:w-72"
        />  

        @if(request('q'))
            <a href="{{ $action }}" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded text-gray-700">Reset</a>
        @endif

        <x-primary-button>Search</x-primary-button>
    </div>
</form>