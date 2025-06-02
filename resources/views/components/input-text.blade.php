@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => old($name),
    'placeholder' => '',
    'disabled' => false,
    'required' => false,
    'autocomplete' => null,
    'autofocus' => false,
])

<div class="text-start w-100">
    @if (!empty($label))
        <label for="{{ $name }}" class="form-label font-playfair main-color">
            {{ $label }}
        </label>
    @endif
    
    <input
        type="{{ $type ?? 'text' }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if ($disabled) disabled @endif
        @if ($required) required @endif
        @if ($autofocus) autofocus @endif

        {{ $attributes->merge([
            'class' => 'form-control bg-body-secondary main-color font-playfair p-2 form-theme rounded border-dark-gold border-0'
        ]) }}
    />
</div>
