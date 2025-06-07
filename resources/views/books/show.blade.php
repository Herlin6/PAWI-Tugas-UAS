@extends('layout.main') @section('title', 'Book Details') @section('content')
<div class="container">
    @include('books.partials.book-detail')
    <hr class="mt-4 mb-3" />
    @include('books.partials.review', ['reviews' => $reviews])
</div>
@endsection
