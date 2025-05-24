@extends('layout.main')
@section('title', 'Book Details')
@section('content')

<div class="container">
    <div class="d-flex justify-content-between align-items-center flex-lg-row flex-column align-items-lg-start">
        <div class=" text-center p-4 pt-0">
            @if ($book->foto)
                <img src="{{ asset('images/' . $book->foto) }}" style="width: 250px">
            @else
                <div class="pt-lg-0">
                    <img src="{{ asset('images/default.png') }}" style="width: 250px">
                </div>
            @endif
            <div>
                @if ($book->availability == 1)
                    <div class="badge main-bg-body g-text-success w-100 p-3 rounded-3 text-center mt-3 fs-6">
                        Available
                    </div>
                @else
                    <div class="badge main-bg-body g-text-danger w-100 p-3 rounded-3 text-center mt-3 fs-6">
                        Not Available
                    </div>
                @endif
            </div>
        </div>
        <div class="">
            <h2 class="mb-3 title-color">{{ $book->title }}</h3>
            <x-desc label="Book Number" content="{{ $book->book_number }}" />
            <x-desc label="Author" content="{{ $book->author }}" />
            <x-desc label="Publisher" content="{{ $book->publisher }}" />
            <x-desc label="ISBN" content="{{ $book->isbn }}" />
            <x-desc label="Genre" content="{{ $book->genre }}" />
            <x-desc label="Publish Date" content="{{ $book->publish_date }}" />
            <x-desc label="Synopsis" content="{{ $book->synopsis }}" />
            <div class="d-flex justify-content-end">
                <a class='nav-link' href='{{ url('books') }}'>
                    <button class="btn main-bg-body main-color">Back</button>
                </a>
            </div>
        </div>
</div>

    </div>
</div>

@endsection