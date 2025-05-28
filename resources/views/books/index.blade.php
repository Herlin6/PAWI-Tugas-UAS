@extends('layout.main')
@section('title', 'Manage Books')
@section('content')

<div class="container">
    <form method="GET" action="{{ route('books.index') }}" class="d-flex align-items-center gap-2">
        <input
            type="text"
            class="form-control form-theme p-3"
            id="search"
            name="search"
            placeholder="Search by title or author"
            value="{{ request('search') }}"
            autocomplete="off"
        >
        <button type="button" id="clearBtn" class="btn btn-theme" style="padding: 1rem">
            Clear
        </button>
    </form>
    
    <div class="mt-4">
        <a href="/" class="btn btn-theme">
            Add Book
        </a>
    </div>

    <div class="mt-1">
        @php
            $columns = include resource_path('contents/book-table.php');
        @endphp
        <x-table :columns="$columns" :data="$books" page="books" />
    </div>
    <script src="{{ asset('js/search.js') }}"></script>
</div>

@endsection