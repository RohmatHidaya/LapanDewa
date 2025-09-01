@props([
    'title' => $title,
    'color' => $color,
    'value',
    'date' => null,
    'formatdate' => null,
])

<div>
        <div class="bg-white shadow rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-gray-700">{{ $title }}</h2>
             @if($formatdate === 'my')
                <span class="text-sm text-gray-500 block mt-0.5">
                    {{ $date->isoFormat('MMMM Y') }}
                </span>
            @elseif($formatdate === 'dmy')
                <span class="text-sm text-gray-500 block mt-0.5">
                    {{ $date->isoFormat('dddd, D MMMM Y') }}
                </span>
            @elseif ($formatdate === 'y')
                <span class="text-sm text-gray-500 block mt-0.5">
                    {{ $date->isoFormat('Y') }}
                </span>
            @endif

            <p class="text-2xl font-bold text-{{ $color }}-600 mt-2">
                Rp {{ number_format($value, 0, ',', '.') }}
            </p>
        </div>
</div>