<div>
    <button
        class="btn me-1"
        style="background-color: #05111d; color: #e2ba76"
        {{ $attributes->merge(['type' => 'button']) }}
        @if(isset($onEdit)) onclick="{{ $onEdit }}" @endif
    >
        <i class="bi bi-pen"></i>
    </button>
    <button
        type="button"
        class="btn ms-1"
        style="background-color: #7b3b3b; color: #e2ba76"
        data-nama="{{ $dataName ?? 'Data' }}"
        @if(isset($onDelete)) onclick="{{ $onDelete }}" @endif
    >
        <i class="bi bi-trash"></i>
    </button>
</div>