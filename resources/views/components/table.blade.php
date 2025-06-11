@php
    use Illuminate\Support\Str;
@endphp
<div class="table-responsive">
    <table class="table table-theme mt-3">
        <tr class="text-center">
            @foreach($columns as $key => $label)
                @if ($key === 'action')
                    @php
                        $modelClass = '\\App\\Models\\' . ucfirst(Str::singular($page));
                        $model = (isset($data[0]) && class_exists($modelClass)) ? app($modelClass)->find($data[0]['id']) : null;
                    @endphp
                    @if($model && auth()->user()->can('update', $model))
                        <th class="px-2 px-lg-5 text-nowrap title-color">{{ $label }}</th>
                    @endif
                @else
                    <th class="px-2 px-lg-5 text-nowrap title-color">{{ $label }}</th>
                @endif
            @endforeach
        </tr>

        @forelse($data as $item)
            @php
                // $aosDuration = 500 + ($loop->index * 5);
                $aosDuration = 500;
            @endphp
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

                    @if ($key === 'action')
                        @php
                            $modelClass = '\\App\\Models\\' . ucfirst(Str::singular($page));
                            $model = class_exists($modelClass) ? $modelClass::find($item['id']) : null;
                        @endphp
                        @if($model && auth()->user()->can('update', $model))
                            <td class="{{ $tdClass }}" data-aos="fade-left" data-aos-duration="{{ $aosDuration }}">
                                <div class="d-flex justify-content-center gap-2">
                                    <x-action-button
                                        :onEdit="'window.location.href=`' . route($page . '.edit', $item['id']) . '`'"
                                        :onDelete="'document.getElementById(\'delete-form-'. $item['id'] .'\').submit()'"
                                    />
                                    <form id="delete-form-{{ $item['id'] }}" action="{{ route($page . '.destroy', $item['id']) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        @endif
                    @elseif ($key === 'availability')
                        <td class="{{ $tdClass }}" data-aos="fade-left" data-aos-duration="{{ $aosDuration }}">
                            {{ $item[$key] == 1 ? 'Available' : 'Not Available' }}
                        </td>
                    @elseif ($key === 'gender')
                        <td class="{{ $tdClass }}" data-aos="fade-left" data-aos-duration="{{ $aosDuration }}">
                            @if ($item[$key] === 'M')
                                <span style="color: #5C8DBC">
                                    <i class="bi bi-gender-male me-1"></i>Male
                                </span>
                            @else
                                <span style="color: #D889A6">
                                    <i class="bi bi-gender-female me-1"></i>Female
                                </span>
                            @endif
                        </td>
                    @elseif (in_array($key, ['name', 'title', 'book_title', 'member_name']))
                        <td class="{{ $tdClass }}" data-aos="fade-left" data-aos-duration="{{ $aosDuration }}">
                            {{ data_get($item, $key, '-') }}
                        </td>
                    @elseif ($key === 'returning')
                        <td class="{{ $tdClass }}" data-aos="fade-left" data-aos-duration="{{ $aosDuration }}">
                            <div class="text-center">
                                @if (in_array($item['loan_status'], ['borrowed', 'overdue']))
                                    <form action="{{ route('loans.return', $item['id']) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <x-dark-button type="submit" class="btn btn-sm">
                                            <i class="bi bi-check2"></i>
                                        </x-dark-button>
                                    </form>
                                @else
                                    Done
                                @endif
                            </div>
                        </td>
                    @else
                        <td class="{{ $tdClass }}" data-aos="fade-left" data-aos-duration="{{ $aosDuration }}">
                            {{ $item[$key] ?? '-' }}
                        </td>
                    @endif
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
