@props([
    'action' => '#',
    'placeholder' => 'Search...',
    'name' => 'q',
    // Autocomplete props
    'autocomplete' => false,
    'endpoint' => null,
    'minChars' => 1,
    'debounceMs' => 200,
    // Generic mapping keys (optional). If null, expects API to return 'label', 'value', 'meta', 'description'
    'labelKey' => null,
    'valueKey' => null,
    'metaKey' => null,
    'descriptionKey' => null,
])

@php
    $initialQuery = request($name);
@endphp

<form method="GET" action="{{ $action }}" class="mb-4"
    @if($autocomplete)
        x-data="autocompleteSearch({
            endpoint: '{{ $endpoint }}',
            minChars: {{ (int)$minChars }},
            debounceMs: {{ (int)$debounceMs }},
            initialQuery: @js($initialQuery),
            labelKey: @js($labelKey),
            valueKey: @js($valueKey),
            metaKey: @js($metaKey),
            descriptionKey: @js($descriptionKey),
        })"
        x-init="init()"
        @click.outside="close()"
    @endif
>
    <div class="flex items-center gap-2">
        <div class="relative w-fit sm:w-72">
            <input 
                type="text" 
                name="{{ $name }}" 
                value="{{ $initialQuery }}" 
                placeholder="{{ $placeholder }}" 
                class="border rounded px-3 py-2 w-full"
                @if($autocomplete)
                    x-model="query"
                    @input.debounce.{{ (int)$debounceMs }}ms="onInput"
                    @keydown.down.prevent="highlightNext()"
                    @keydown.up.prevent="highlightPrev()"
                    @keydown.enter.prevent="onEnter()"
                    autocomplete="off"
                @endif
            />  

            @if($autocomplete)
            <!-- Suggestions dropdown -->
            <div
                class="absolute left-0 top-full mt-1 w-full bg-white border rounded shadow z-20 max-h-72 overflow-auto"
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
                    <template x-for="(item, idx) in suggestions" :key="item.id">
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
            @endif
        </div>

        @if(request($name))
            <a href="{{ $action }}" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded text-gray-700">Reset</a>
        @endif

        <x-primary-button>Search</x-primary-button>
    </div>
</form>

@if($autocomplete)
<script>
    if (!window.autocompleteSearch) {
        window.autocompleteSearch = function ({ endpoint, minChars = 1, debounceMs = 200, initialQuery = '', labelKey = null, valueKey = null, metaKey = null, descriptionKey = null }) {
            return {
                endpoint,
                minChars,
                debounceMs,
                labelKey,
                valueKey,
                metaKey,
                descriptionKey,
                query: initialQuery || '',
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
                        // Submit the form normally
                        this.$root.submit();
                    }
                },
                select(item) {
                    this.query = this.getValue(item);
                    this.$root.querySelector('input[name="{{ $name }}"]').value = this.getValue(item);
                    this.open = false;
                    // Submit to the listing with selected term
                    this.$root.submit();
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
                // Helpers for mapping
                getValue(item) {
                    if (this.valueKey && item[this.valueKey] != null) return item[this.valueKey];
                    if (item.value != null) return item.value;
                    // fallback ke label jika tidak ada
                    return this.getLabel(item);
                },
                getLabel(item) {
                    if (this.labelKey && item[this.labelKey] != null) return item[this.labelKey];
                    if (item.label != null) return item.label;
                    // fallback umum: nama/name
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
@endif
