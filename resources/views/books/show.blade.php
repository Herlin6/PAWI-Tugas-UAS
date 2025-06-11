@extends('layout.general') @section('content')
<div class="container" style="overflow-x: hidden">
    @include('books.partials.book-detail')
    <hr class="mt-4 mb-3" />
    <div data-aos="zoom-in" data-aos-duration="700">
        @include('books.partials.review', ['reviews' => $reviews])
    </div>
</div>
@endsection
