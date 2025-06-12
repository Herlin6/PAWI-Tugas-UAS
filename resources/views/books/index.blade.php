@extends('layout.main')
@section('title', 'Manage Books')
@section('content')

<div class="container">
    <x-search placeholder="Search by title or author" />
    
    <div class="mt-4" data-aos="zoom-in" data-aos-duration="700">
        @can('create', App\Models\Book::class)
            <x-button href="{{ route('books.create') }}">
                Add Book
            </x-button>
        @endcan
    </div>

    <div class="mt-1" data-aos="fade-up" data-aos-duration="700">
        @php
            $columns = include resource_path('contents/book-table.php');
        @endphp
        <x-table :columns="$columns" :data="$books" page="books" />
        <div class="mt-4 d-flex justify-content-center">
            {{ $books->links('pagination::custom-pagination') }}
        </div>
    </div>
</div>

@endsection