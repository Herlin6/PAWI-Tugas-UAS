@props([
    'type' => 'button',
    'id' => null,
    'onclick' => null,
    'href' => null,
])

@if ($href)
    <a
        href="{{ $href }}"
        @isset($id) id="{{ $id }}" @endisset
        @isset($onclick) onclick="{{ $onclick }}" @endisset
        style="background-color: #0f1d2a; color: #f5f5dc;"
        {{ $attributes->merge(['class' => 'btn dark-btn-theme font-open-sans rounded']) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        @isset($id) id="{{ $id }}" @endisset
        @isset($onclick) onclick="{{ $onclick }}" @endisset
        style="background-color: #0f1d2a; color: #f5f5dc;"
        {{ $attributes->merge(['class' => 'btn dark-btn-theme font-open-sans rounded']) }}
    >
        {{ $slot }}
    </button>
@endif
