@extends('layout.main')
@section('title', 'Manage Books')
@section('content')

<div class="container">
    <x-search placeholder="Search by title or author" />
    
    <div class="mt-4">
        @can('create', App\Models\Book::class)
            <x-button href="{{ route('books.create') }}">
                Add Book
            </x-button>
        @endcan
    </div>

    <div class="mt-1">
        @php
            $columns = include resource_path('contents/book-table.php');
        @endphp
        <x-table :columns="$columns" :data="$books" page="books" />
    </div>
</div>

@endsection