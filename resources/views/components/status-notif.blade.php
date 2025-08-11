<div>
    @props(['type' => 'info', 'message' => session('message')])

    @if ($message)
        @php
            $colors = [
            'success' => 'bg-green-100 text-green-800',
            'error' => 'bg-red-100 text-red-800',
            'warning' => 'bg-yellow-100 text-yellow-800',
            'info' => 'bg-blue-100 text-blue-800',
        ];
        @endphp
        {{-- <div class="rounded px-4 py-3 my-4 border {{ $colors[$type] ?? $colors['info'] }}">
        {{ $message }}
    </div> --}}
    <p
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 2500)"
        class=" {{ $colors[$type] ?? $colors['info'] }} fixed top-55 left-1/2 transform -translate-x-1/2 bg-green-100 text-green-800 px-6 py-2 rounded shadow-lg z-50 text-sm">
        {{ $message }}
    </p>
    @endif
</div>