<style>
    #{{ $name }}::placeholder {
        color: #757575;
    }
</style>

<div class="row mb-3">
    <label for="{{ $name }}" class="col-lg-2 mr-4 font-playfair sub-title-color">{{ $label }}</label>
    <div class="col-lg-10">
        @if ($type === 'textarea')
            <textarea 
    id="{{ $name }}" 
    name="{{ $name }}" 
    rows="{{ $rows ?? 3 }}" 
    placeholder="{{ $placeholder ?? '' }}"
    class="form-control bg-body-secondary main-color font-playfair border-dark-gold" 
    {{ $required ? 'required' : '' }}
>{{ old($name) }}</textarea>
        @endif
    </div>
</div>
