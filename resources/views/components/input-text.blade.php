@props([
    'name',
    'label' => null,
    'inRowLabel' => null,
    'type' => 'text',
    'value' => old($name),
    'placeholder' => '',
    'disabled' => false,
    'required' => false,
    'autocomplete' => null,
    'autofocus' => false,
    'errorMessage' => null,
    'class' => '', // Tambahkan ini agar bisa menerima class tambahan
])

<style>
    input[type="date"].custom-date::-webkit-calendar-picker-indicator {
        filter: invert(69%) sepia(31%) saturate(362%) hue-rotate(2deg) brightness(94%) contrast(91%);
    }
</style>

<div class="text-start w-100">
    @if (!empty($inRowLabel))
        <div class="row align-items-center mb-3">
            <label for="{{ $name }}" class="col-lg-2 col-form-label font-playfair sub-title-color">
                {{ $inRowLabel }}
            </label>
            <div class="col-lg-10">
                <input
                    type="{{ $type }}"
                    name="{{ $name }}"
                    id="{{ $name }}"
                    value="{{ $value }}"
                    placeholder="{{ $placeholder }}"
                    @if ($autocomplete) autocomplete="{{ $autocomplete }}" @else autocomplete="off" @endif
                    @if ($disabled) disabled @endif
                    @if ($required) required @endif
                    @if ($autofocus) autofocus @endif
                    @if ($type === 'date')
                        class="form-control bg-body-secondary main-color font-playfair p-2 form-theme rounded border-dark-gold border-0 custom-date {{ $class }}"
                    @else
                        class="form-control bg-body-secondary main-color font-playfair p-2 form-theme rounded border-dark-gold border-0 {{ $class }}"
                    @endif
                    {{ $attributes }}
                />
                @if(!empty($errorMessage))
                    <div class="g-text-danger font-playfair mt-1">{{ $errorMessage }}</div>
                @endif
            </div>
        </div>
    @else
        @if (!empty($label))
            <label for="{{ $name }}" class="form-label font-playfair main-color">
                {{ $label }}
            </label>
        @endif
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @else autocomplete="off" @endif
            @if ($disabled) disabled @endif
            @if ($required) required @endif
            @if ($autofocus) autofocus @endif
            @if ($type === 'date')
                class="form-control bg-body-secondary main-color font-playfair p-2 form-theme rounded border-dark-gold border-0 custom-date {{ $class }}"
            @else
                class="form-control bg-body-secondary main-color font-playfair p-2 form-theme rounded border-dark-gold border-0 {{ $class }}"
            @endif
            {{ $attributes }}
        />
        @if(!empty($errorMessage))
            <div class="g-text-danger font-playfair mt-1">{{ $errorMessage }}</div>
        @endif
    @endif
</div>