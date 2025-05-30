<div class="text-start w-100">
    @if (!empty($inRowLabel))
        <div class="row align-items-center mb-3">
            <label for="{{ $name }}" class="col-2 col-form-label font-playfair sub-title-color">
                {{ $inRowLabel }}
            </label>
            <div class="col-10">
                <input
                    type="{{ $type ?? 'text' }}"
                    name="{{ $name }}"
                    id="{{ $name }}"
                    value="{{ $value ?? '' }}"
                    placeholder="{{ $placeholder ?? '' }}"
                    autocomplete="off"
                    {{ $attributes->merge(['class' => 'form-control bg-body-secondary main-color font-playfair p-2 form-theme rounded border-dark-gold border-0']) }}
                />
            </div>
        </div>
    @else
        @if (!empty($label))
            <label for="{{ $name }}" class="form-label font-playfair main-color">
                {{ $label }}
            </label>
        @endif
        <input
            type="{{ $type ?? 'text' }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ $value ?? '' }}"
            placeholder="{{ $placeholder ?? '' }}"
            autocomplete="off"
            {{ $attributes->merge(['class' => 'form-control bg-body-secondary main-color font-playfair p-2 form-theme rounded border-dark-gold border-0']) }}
        />
    @endif
</div>
