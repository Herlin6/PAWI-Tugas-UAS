<button
    type="{{ $type ?? 'button' }}"
    @isset($id) id="{{ $id }}" @endisset
    style="background-color: #997740"
    {{ $attributes->merge(['class' => 'btn btn-theme main-color font-open-sans rounded']) }}
>
    {{ $slot }}
</button>