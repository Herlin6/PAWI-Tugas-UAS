@extends('layout.user')
@section('content')
<style>
    .clickable-row {
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.clickable-row:hover {
    transform: scale(1.015);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}
</style>
<div class="container">
    <h1 class="text-center mb-5 title-color">Loan History</h1>

    <div class="table-responsive">
        <table class="table table-theme table-hover mt-3">
            <thead class="text-center">
            <tr data-aos="fade-left" data-aos-duration="500">
                <th>Book</th>
                <th>Title</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($loans as $loan)
            @php
                    $statusClass = match($loan->loan_status) {
                        'returned' => 'g-text-success',
                        'borrowed' => 'g-text-warning',
                        default => 'g-text-danger',
                    };
                    @endphp
                <tr class="align-middle clickable-row" data-href="{{ route('loans.show', $loan->id) }}" data-aos="fade-left" data-aos-duration="500">
                    <td class="text-center">
                        @if ($loan->book->photo && file_exists(public_path($loan->book->photo)))
                            <img src="{{ asset($loan->book->photo) }}" alt="Cover" style="height: 65px; object-fit: cover;" class="rounded">
                        @else
                            <img src="{{ asset('images/book-default.png') }}" alt="No Cover" style="height: 65px; object-fit: cover;" class="rounded">
                        @endif
                    </td>
                    <td>{{ $loan->book->title }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($loan->borrow_date)->format('d M Y') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</td>
                    <td class="text-center {{ $statusClass }}">
                        {{ ucfirst($loan->loan_status) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No loan history available.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
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
<script>
    window.addEventListener('load', function () {
        AOS.init({
            once: false,
            mirror: true,
            offset: 0,
        });

        setTimeout(() => AOS.refresh(), 100);
    });
</script>