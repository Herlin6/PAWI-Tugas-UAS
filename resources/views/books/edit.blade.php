@extends('layout.main') 
@section('title', 'Edit Book') 
@section('content')
<div class="container form-container">
    <form
        method="POST"
        action="{{ route('books.update', $book->id) }}"
        enctype="multipart/form-data"
    >
        @csrf 
        @method('PUT')

        <div class="d-flex justify-content-between align-items-start flex-lg-row flex-column">
            <div class="text-center p-4 pt-0">
                <div class="mb-3 d-flex flex-column align-items-center">
                    @if ($book->photo && file_exists(public_path('images/' . $book->photo)))
                        <img src="{{ asset('images/' . $book->photo) }}" style="width: 250px" />
                    @else
                        <img src="{{ asset('images/book-default.png') }}" style="width: 250px" />
                    @endif
                    <input
                        type="file"
                        name="photo"
                        id="photo"
                        class="form-control form-control-sm mt-2"
                    />
                    @error('photo')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="w-100">
                <x-input-text
                    inRowLabel="Book Number"
                    name="book_number"
                    required="true"
                    placeholder="Enter number"
                    value="{{ old('book_number') ? old('book_number') : $book->book_number }}"
                />
                <x-input-text
                    inRowLabel="Title"
                    name="title"
                    required="true"
                    placeholder="Enter title"
                    value="{{ old('title') ? old('title') : $book->title }}"
                />
                <x-input-text
                    inRowLabel="Author"
                    name="author"
                    required="true"
                    placeholder="Enter author"
                    value="{{ old('author') ? old('author') : $book->author }}"
                />
                <x-input-text
                    inRowLabel="Publisher"
                    name="publisher"
                    required="true"
                    placeholder="Enter publisher"
                    value="{{ old('publisher') ? old('publisher') : $book->publisher }}"
                />
                <x-input-text
                    inRowLabel="ISBN"
                    name="isbn"
                    required="true"
                    placeholder="Enter ISBN"
                    value="{{ old('isbn') ? old('isbn') : $book->isbn }}"
                />
                <x-input-option
                    label="Genre"
                    name="genre"
                    type="select"
                    :options="[
                        'Fiction' => 'Fiction',
                        'Non-Fiction' => 'Non-Fiction',
                        'Science' => 'Science',
                        'Technology' => 'Technology',
                        'History' => 'History',
                        'Literature' => 'Literature',
                    ]"
                    required="true"
                    placeholder="Select genre"
                    :value="old('genre', $book->genre)"
                />
                @php 
                    use Carbon\Carbon; 
                    $publishDate = old('publish_date') ?: $book->publish_date; 
                    $publishDate = $publishDate ? Carbon::parse($publishDate)->format('Y-m-d') : ''; 
                @endphp
                <x-input-text
                    inRowLabel="Publish Date"
                    name="publish_date"
                    type="date"
                    required="true"
                    value="{{ $publishDate }}"
                />
                <x-input-text-area
                    label="Synopsis"
                    name="synopsis"
                    type="textarea"
                    rows="3"
                    required="true"
                    placeholder="Enter synopsis"
                    value="{{ old('synopsis') ? old('synopsis') : $book->synopsis }}"
                />
                <x-input-option
                    label="Availability"
                    name="availability"
                    type="select"
                    :options="[1 => 'Available', 0 => 'Not Available']"
                    required="true"
                    :value="old('availability', $book->availability)"
                />
                <div class="form-buttons mt-4 d-flex justify-content-between">
                    <x-dark-button onclick="window.history.back()">
                        <i class="bi bi-arrow-left"></i> Back
                    </x-dark-button>
                    <x-button type="submit">Update Book</x-button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection