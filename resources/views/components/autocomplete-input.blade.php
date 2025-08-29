@props([
    'name' => 'q',
    'value' => null,
    'placeholder' => 'Search...',
    'endpoint' => null,
    'minChars' => 1,
    'debounceMs' => 200,
    // Mapping keys (opsional). Jika null, komponen mengharapkan API return 'label', 'value', 'meta', 'description'.
    'labelKey' => null,
    'valueKey' => null,
    'metaKey' => null,
    'descriptionKey' => null,
    // Submit form induk saat memilih item
    'submitOnSelect' => false,
    // Atur atribut tambahan input jika diperlukan
    'inputClass' => 'border rounded px-3 py-2 w-full',
])

@php
    $initialValue = old($name, $value);
@endphp

<div class="relative w-fit sm:w-72"
    x-data="autocompleteInput({
        endpoint: '{{ $endpoint }}',
        minChars: {{ (int)$minChars }},
        debounceMs: {{ (int)$debounceMs }},
        initialValue: @js($initialValue),
        labelKey: @js($labelKey),
        valueKey: @js($valueKey),
        metaKey: @js($metaKey),
        descriptionKey: @js($descriptionKey),
        submitOnSelect: {{ $submitOnSelect ? 'true' : 'false' }},
    })"
    x-init="init()"
    @click.outside="close()"
>
    <input
        type="text"
        name="{{ $name }}"
        value="{{ $initialValue }}"
        placeholder="{{ $placeholder }}"
        class="{{ $inputClass }}"
        x-model="query"
        @input.debounce.{{ (int)$debounceMs }}ms="onInput"
        @keydown.down.prevent="highlightNext()"
        @keydown.up.prevent="highlightPrev()"
        @keydown.enter.prevent="onEnter()"
        autocomplete="off"
    />

    <!-- Dropdown saran -->
    <div class="absolute left-0 top-full mt-1 w-full bg-white border rounded shadow z-20 max-h-72 overflow-auto"
        x-show="open"
        x-transition
        @mousedown.prevent
    >
        <template x-if="loading">
            <div class="p-3 text-sm text-gray-500">Loading...</div>
        </template>

        <template x-if="!loading && suggestions.length === 0 && query.length >= minChars">
            <div class="p-3 text-sm text-gray-500">Tidak ada hasil</div>
        </template>

        <ul>
            <template x-for="(item, idx) in suggestions" :key="item.id ?? idx">
                <li>
                    <button type="button"
                        class="w-full text-left px-3 py-2 hover:bg-gray-100"
                        :class="{ 'bg-gray-100': idx === highlighted }"
                        @mouseenter="highlighted = idx"
                        @mouseleave="highlighted = -1"
                        @click="select(item)"
                    >
                        <div class="flex items-center justify-between">
                            <span class="font-medium" x-text="displayLabel(item)"></span>
                            <span class="text-xs text-gray-500" x-text="displayMeta(item)"></span>
                        </div>
                        <div class="text-xs text-gray-600" x-text="displayDescription(item)"></div>
                    </button>
                </li>
            </template>
        </ul>
    </div>
</div>

<script>
    if (!window.autocompleteInput) {
        window.autocompleteInput = function ({ endpoint, minChars = 1, debounceMs = 200, initialValue = '', labelKey = null, valueKey = null, metaKey = null, descriptionKey = null, submitOnSelect = false }) {
            return {
                endpoint,
                minChars,
                debounceMs,
                labelKey,
                valueKey,
                metaKey,
                descriptionKey,
                submitOnSelect,
                query: initialValue || '',
                open: false,
                loading: false,
                suggestions: [],
                highlighted: -1,
                controller: null,
                init() {
                    if (this.query && this.query.length >= this.minChars) {
                        this.fetchSuggestions();
                    }
                },
                onInput() {
                    if (this.query.length < this.minChars) {
                        this.suggestions = [];
                        this.open = false;
                        return;
                    }
                    this.fetchSuggestions();
                },
                close() { this.open = false; },
                highlightNext() { if (this.suggestions.length) { this.highlighted = (this.highlighted + 1) % this.suggestions.length; } },
                highlightPrev() { if (this.suggestions.length) { this.highlighted = (this.highlighted - 1 + this.suggestions.length) % this.suggestions.length; } },
                onEnter() {
                    if (this.highlighted >= 0 && this.suggestions[this.highlighted]) {
                        this.select(this.suggestions[this.highlighted]);
                    } else {
                        if (this.submitOnSelect) {
                            const form = this.$root.closest('form');
                            if (form) form.submit();
                        }
                    }
                },
                select(item) {
                    // Nilai input yang dikirim (misal barcode untuk kasir) diambil dari valueKey/value
                    this.query = this.getValue(item);
                    this.open = false;
                    if (this.submitOnSelect) {
                        const form = this.$root.closest('form');
                        if (form) form.submit();
                    }
                },
                async fetchSuggestions() {
                    try {
                        if (!this.endpoint) return;
                        if (this.controller) this.controller.abort();
                        this.controller = new AbortController();
                        this.loading = true;
                        const url = new URL(this.endpoint, window.location.origin);
                        url.searchParams.set('q', this.query);
                        const res = await fetch(url.toString(), { signal: this.controller.signal, headers: { 'Accept': 'application/json' } });
                        if (!res.ok) throw new Error('Network error');
                        const data = await res.json();
                        this.suggestions = Array.isArray(data) ? data : [];
                        this.open = this.suggestions.length > 0;
                        this.highlighted = -1;
                    } catch (e) {
                        if (e.name !== 'AbortError') {
                            console.error(e);
                        }
                    } finally {
                        this.loading = false;
                    }
                },
                // Mapping helpers
                getValue(item) {
                    if (this.valueKey && item[this.valueKey] != null) return item[this.valueKey];
                    if (item.value != null) return item.value;
                    return this.getLabel(item);
                },
                getLabel(item) {
                    if (this.labelKey && item[this.labelKey] != null) return item[this.labelKey];
                    if (item.label != null) return item.label;
                    return item.nama ?? item.name ?? '';
                },
                getMeta(item) {
                    if (this.metaKey && item[this.metaKey] != null) return item[this.metaKey];
                    return item.meta ?? '';
                },
                getDescription(item) {
                    if (this.descriptionKey && item[this.descriptionKey] != null) return item[this.descriptionKey];
                    return item.description ?? '';
                },
                displayLabel(item) { return this.getLabel(item); },
                displayMeta(item) { return this.getMeta(item); },
                displayDescription(item) { return this.getDescription(item); },
            }
        }
    }
</script>
