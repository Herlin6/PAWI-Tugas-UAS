@extends('layout.main')
@section('title', 'Manage Loans')
@section('content')

<div class="container">
    <x-search route="loans.index" placeholder="Search by member or book" />

    <div class="mt-4">
        <x-button href="/">
            Add Loan
        </x-button>
    </div>

    <div class="mt-1">
        @php
            $columns = include resource_path('contents/loan-table.php');
        @endphp
        <x-table :columns="$columns" :data="$loans" page="loans" />
    </div>
    <script src="{{ asset('js/search.js') }}"></script>
</div>

@endsection