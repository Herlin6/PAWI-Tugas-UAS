@extends('layout.main')
@section('title', 'Manage Books')
@section('content')

<div class="container">
    <form method="GET" action="{{ route('books.index') }}" class="d-flex align-items-center gap-2">
        <x-input-text
            name="search"
            placeholder="Search by title or author"
            value="{{ request('search') }}"
            class="p-3"
        />
        <x-button id="clearBtn" class="p-3">
            Clear
        </x-button>
    </form>
    
    <div class="mt-4">
        <a href="/">
            <x-button>
                Add Book
            </x-button>
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