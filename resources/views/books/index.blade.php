@extends('layout.main')
@section('title', 'Manage Books')
@section('content')

<div class="container">
    <x-search route="books.index" placeholder="Search by title or author" />
    
    <div class="mt-4">
        <a href="{{ route('books.create') }}">
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
</div>

@endsection