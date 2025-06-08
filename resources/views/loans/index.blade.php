@extends('layout.main')
@section('title', 'Manage Loans')
@section('content')

<div class="container">
    <x-search placeholder="Search by member or book" />

    <div class="mt-4">
        @can('create', App\Models\Loan::class)
            <x-button href="{{ route('loans.create') }}">
                Add Loan
            </x-button>
        @endcan
    </div>

    <div class="mt-1">
        @php
            $columns = include resource_path('contents/loan-table.php');
        @endphp
        <x-table :columns="$columns" :data="$tableData" page="loans" />
    </div>
    <script src="{{ asset('js/search.js') }}"></script>
</div>

@endsection