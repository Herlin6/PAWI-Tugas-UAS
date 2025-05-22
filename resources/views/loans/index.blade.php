@extends('layout.main')
@section('title', 'Manage Loans')
@section('content')

<div class="container">
    <form method="GET" action="{{ route('loans.index') }}" class="d-flex align-items-center gap-2">
        <input
            type="text"
            class="form-control form-theme"
            id="search"
            name="search"
            placeholder="Search by member or book"
            value="{{ request('search') }}"
            autocomplete="off"
        >
        <button type="button" id="clearBtn" class="btn btn-theme" style="padding: 1rem">
            Clear
        </button>
    </form>
    
    <div class="mt-4">
        <a href="/" class="btn btn-theme">
            Add Loan
        </a>
    </div>

    <div class="mt-1">
        @php
            $columns = include resource_path('contents/loan-table.php');
        @endphp
        <x-table :columns="$columns" :data="$loans" />
    </div>
    <script src="{{ asset('js/search.js') }}"></script>
</div>

@endsection