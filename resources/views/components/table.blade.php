<div class="table-responsive">
    <table class="table table-theme mt-3">
        <tr class="text-center">
            @foreach($columns as $key => $label)
                <th class="px-2 px-lg-5 text-nowrap">{{ $label }}</th>
            @endforeach
        </tr>

        @forelse($data as $item)
            <tr class="align-middle">
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
                            {{ $item[$key] === 'M' ? 'Male' : 'Female' }}

                        @elseif (in_array($key, ['name', 'title', 'book_title', 'member_name']))
                            <a href="{{ route($page . '.show', $item['id']) }}"
                               class="text-decoration-none text-reset">
                                {{ $item[$key] }}
                            </a>

                        @elseif ($key === 'returning')
                            <div class="text-center">
                                @if (in_array($item['loan_status'], ['borrowed', 'overdue']))
                                    <button class="btn btn-sm btn-theme">Done</button>
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
