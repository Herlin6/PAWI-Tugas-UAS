<button
    type="{{ $type ?? 'button' }}"
    @isset($id) id="{{ $id }}" @endisset
    style="background-color: #0f1d2a; color: #f5f5dc;"
    {{ $attributes->merge(['class' => 'btn dark-btn-theme font-open-sans rounded']) }}
>
    {{ $slot }}
</button>
