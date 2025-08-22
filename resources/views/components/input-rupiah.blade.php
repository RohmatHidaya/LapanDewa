@props([
    'name' => 'jumlah',
    'label' => 'Jumlah',
    'placeholder' => 'Masukkan nominal',
])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>

    <input type="hidden" name="{{ $name }}" id="{{ $name }}_hidden">

    <input 
        type="text" 
        id="{{ $name }}" 
        {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}
        placeholder="{{ $placeholder }}"
        required
    >
</div>

@once
<script>
    function formatRupiahInput(inputId) {
        const input = document.getElementById(inputId);
        const hidden = document.getElementById(inputId + "_hidden");
        if (!input) return;

        input.addEventListener('keyup', function() {
            let angka = this.value.replace(/[^,\d]/g, '');
            let formatted = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            this.value = angka ? 'Rp ' + formatted : '';
        });

        input.form.addEventListener('submit', function() {
            if (hidden) hidden.value = input.value.replace(/[^,\d]/g, '');
        });
    }
</script>
@endonce

<script>
    formatRupiahInput("{{ $name }}");
</script>