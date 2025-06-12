<div class="container py-2 ms-lg-2 d-flex justify-content-between align-items-center flex-lg-row flex-column">
    <h1 class="mb-3 title-color">{{ $book->title }}</h1>
    @if (Auth::user()->role === 'admin')
        <x-action-button
            :onEdit="'window.location.href=`' . route('books.edit', $book->id) . '`'"
            :onDelete="'document.getElementById(\'delete-book-form\').submit()'"
        />
        <form id="delete-book-form" action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    @endif
</div>
<div
    class="d-flex align-items-center flex-lg-row flex-column align-items-lg-start"
>
    <div class="text-center p-4 pt-0" data-aos="fade-right" data-aos-duration="500">
        @if ($book->photo)
            <img src="{{ $book->photo }}" style="width: 200px" />
        @else
            <img src="{{ asset('images/book-default.png') }}" style="width: 200px" />
        @endif
        <div>
            @if ($book->availability == 1)
            <div
                class="badge main-bg-body g-text-success w-100 p-3 rounded-3 text-center mt-3 fs-6"
            >
                Available
            </div>
            @else
            <div
                class="badge main-bg-body g-text-danger w-100 p-3 rounded-3 text-center mt-3 fs-6"
            >
                Not Available
            </div>
            @endif
        </div>
    </div>
    <div class="w-100">
        <div data-aos="fade-left" data-aos-duration="400">
            <x-desc label="Book Number" content="{{ $book->book_number }}" />
        </div>
        <div data-aos="fade-left" data-aos-duration="500">
            <x-desc label="Author" content="{{ $book->author }}" />
        </div>
        <div data-aos="fade-left" data-aos-duration="600">
            <x-desc label="Publisher" content="{{ $book->publisher }}" />
        </div>
        <div data-aos="fade-left" data-aos-duration="700">
            <x-desc label="ISBN" content="{{ $book->isbn }}" />
        </div>
        <div data-aos="fade-left" data-aos-duration="800">
            <x-desc label="Genre" content="{{ $book->genre }}" />
        </div>
        <div data-aos="fade-left" data-aos-duration="900">
            <x-desc label="Publish Date" content="{{ $book->publish_date->format('Y-m-d') }}" />
        </div>
        <div data-aos="fade-left" data-aos-duration="1000">
            <x-desc label="Synopsis" content="{{ $book->synopsis }}" />
        </div>
        <div class="d-flex justify-content-end pe-2">
            <x-dark-button class="btn btn-sm" href="{{ route('books.index') }}">
                <i class="bi bi-arrow-left"></i> Back
            </x-dark-button>
        </div>
    </div>
</div>
