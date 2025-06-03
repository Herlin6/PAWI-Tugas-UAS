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
        style="background-color: #997740"
        {{ $attributes->merge(['class' => 'btn btn-theme main-color font-open-sans rounded']) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        @isset($id) id="{{ $id }}" @endisset
        @isset($onclick) onclick="{{ $onclick }}" @endisset
        style="background-color: #997740"
        {{ $attributes->merge(['class' => 'btn btn-theme main-color font-open-sans rounded']) }}
    >
        {{ $slot }}
    </button>
@endif
