<div class="table-responsive">
    <table class="table table-theme mt-3">
        <tr class="text-center">
            @foreach($columns as $key => $label)
                <th class="px-2 px-lg-5 text-nowrap title-color">{{ $label }}</th>
            @endforeach
        </tr>

        @forelse($data as $item)
            <tr class="align-middle clickable-row" data-href="{{ route($page . '.show', $item['id']) }}">
                @foreach($columns as $key => $label)
                    @php
                        $tdClass = '';
                        if ($key === 'availability') {
                            $tdClass = $item[$key] == 1 ? 'g-text-success text-center' : 'g-text-danger text-center';
                        } elseif ($key === 'loan_status') {
                            $tdClass = 'text-center ' . match($item[$key]) {
                                'returned' => 'g-text-success',
                                'borrowed' => 'g-text-warning',
                                default => 'g-text-danger',
                            };
                        } elseif (in_array($key, ['action', 'gender', 'borrow_date', 'due_date'])) {
                            $tdClass = 'text-center';
                        }
                    @endphp

                    <td class="{{ $tdClass }}">
                        @if ($key === 'action')
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm" style="background-color: #05111D; color: #e2ba76">
                                    <i class="bi bi-pen"></i>
                                </button>
                                <button class="btn btn-sm" style="background-color: #7B3B3B; color: #e2ba76">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                        @elseif ($key === 'availability')
                            {{ $item[$key] == 1 ? 'Available' : 'Not Available' }}

                        @elseif ($key === 'gender')
                            @if ($item[$key] === 'M')
                                <span style="color: #5C8DBC">
                                    <i class="bi bi-gender-male me-1"></i>Male
                                </span>
                            @else
                                <span style="color: #D889A6">
                                    <i class="bi bi-gender-female me-1"></i>Female
                                </span>
                            @endif

                        @elseif (in_array($key, ['name', 'title', 'book_title', 'member_name']))
                                {{ $item[$key] }}

                        @elseif ($key === 'returning')
                            <div class="text-center">
                                @if (in_array($item['loan_status'], ['borrowed', 'overdue']))
                                    <x-dark-button type="button" class="btn btn-sm">
                                        <i class="bi bi-check2"></i>
                                    </x-dark-button>
                                @else
                                    Done
                                @endif
                            </div>

                        @else
                            {{ $item[$key] ?? '-' }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($columns) }}" class="text-center py-4 main-color">
                    Empty Data ☹️
                </td>
            </tr>
        @endforelse
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('.clickable-row');
        rows.forEach(row => {
            row.style.cursor = 'pointer';
            row.addEventListener('click', function (e) {
                if (!e.target.closest('button') && !e.target.closest('a')) {
                    window.location.href = this.dataset.href;
                }
            });
        });
    });
</script>
