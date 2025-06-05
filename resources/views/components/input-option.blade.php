<div class="row mb-3 align-items-center">
    <label for="{{ $name }}" class="col-lg-2 mr-4 font-playfair sub-title-color">{{ $label }}</label>
    <div class="col-lg-10">
        @if ($type === 'select' && is_array($options))
            <select 
                id="{{ $name }}" 
                name="{{ $name }}" 
                class="form-control bg-body-secondary font-playfair border-dark-gold main-color" 
                {{ $required ? 'required' : '' }}
            >
                <option value="" disabled selected hidden>{{ $placeholder ?? 'Enter genre' }}</option>
                @foreach ($options as $value => $labelOption)
                    <option value="{{ $value }}" {{ old($name) == $value ? 'selected' : '' }}>
                        {{ $labelOption }}
                    </option>
                @endforeach
            </select>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('{{ $name }}');
        const mainColorClass = 'main-color';

        function updateSelectColor() {
            if (select.value === "") {
                select.style.color = '#e0dbc0'; 
                select.classList.remove(mainColorClass);
            } else {
                select.style.color = ''; 
                select.classList.add(mainColorClass); 
            }
        }

        select.addEventListener('change', updateSelectColor);
        updateSelectColor(); 
    });
</script>
