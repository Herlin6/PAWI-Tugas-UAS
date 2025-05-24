@props(['type' => 'text', 'name', 'label', 'placeholder' => ''])

<div class="mb-3 text-start">
    <label for="{{ $name }}" class="form-label font-playfair main-color">
        {{ $label }}
    </label>
    <input 
        class = "form-control form-theme border-0"
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        placeholder="{{ $placeholder }}" 
    >
</div>
