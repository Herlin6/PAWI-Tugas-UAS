@extends('layout.general') @section('content')
<div class="container" style="overflow-x: hidden">
    @include('books.partials.book-detail')
    <hr class="mt-4 mb-3" />
        @include('books.partials.review', ['reviews' => $reviews])
</div>
@endsection
