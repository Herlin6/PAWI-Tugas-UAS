<table class="table table-theme mt-3">
    <tr class="text-center">
        @foreach($columns as $key => $label)
            <th class="pe-lg-5 ps-lg-5">{{ $label }}</th>
        @endforeach
    </tr>
    @forelse($data as $item)
        <tr class="align-middle">
            @foreach($columns as $key => $label)
                <td
                    @if($key == 'availability')
                        class="text-center {{ $item[$key] == 1 ? 'g-text-success' : 'g-text-danger' }}"
                    @elseif($key == 'loan_status')
                        class="text-center {{
                            $item[$key] == 'returned' ? 'g-text-success' :
                            ($item[$key] == 'borrowed' ? 'g-text-warning' : 'g-text-danger')
                        }}"
                    @elseif($key == 'action' || $key == 'gender' || $key == 'borrow_date' || $key == 'due_date')
                        class="text-center"
                    @endif
                >
                    @if($key == 'action')
                        <button class="btn me-1" style="background-color: #05111D; color: #e2ba76">
                            <i class="bi bi-pen"></i>
                        </button>
                        <button class="btn ms-1" style="background-color: #7B3B3B; color: #e2ba76">
                            <i class="bi bi-trash"></i>
                        </button>
                    @elseif($key == 'availability')
                        {{ $item[$key] == 1 ? 'Available' : 'Not Available' }}
                    @elseif($key == 'gender')
                        {{ $item[$key] == "M" ? 'Male' : 'Female' }}
                    @elseif ($key == 'name' || $key == 'title' || $key == 'book_title' || $key == 'member_name')
                        <a class="text-decoration-none text-reset" href="{{ route($page . '.show', $item['id']) }}">
                            {{ $item[$key] }}
                        </a>
                    @elseif ($key == 'returning')
                        @if ($item['loan_status'] == 'borrowed' || $item['loan_status'] == 'overdue')
                            <div class="text-center">
                                <button class="btn btn-theme">Done</button>
                            </div>
                        @else
                            <div class="text-center">
                                Done
                            </div>
                        @endif
                    @else
                        {{ $item[$key] ?? '-' }}                        
                    @endif

                </td>
            @endforeach
        </tr>
    @empty
        <tr>
            <td colspan="{{ count($columns) }}" class="text-center py-4 main-color">Empty Data ☹️</td>
        </tr>
    @endforelse
</table>
