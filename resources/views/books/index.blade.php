@extends('layout.main')
@section('title', 'Manage Books')
@section('content')

<div class="container">
    <x-search route="books.index" placeholder="Search by title or author" />
    
    <div class="mt-4">
        <x-button href="{{ route('books.create') }}">
            Add Book
        </x-button>
    </div>

    <div class="mt-1">
        @php
            $columns = include resource_path('contents/book-table.php');
        @endphp
        <x-table :columns="$columns" :data="$books" page="books" />
    </div>
</div>

@endsection