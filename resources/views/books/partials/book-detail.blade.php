<div
    class="d-flex align-items-center flex-lg-row flex-column align-items-lg-start"
>
    <div class="text-center p-4 pt-0">
        @if ($book->photo && file_exists(public_path('images/' . $book->photo)))
            <img src="{{ asset('images/' . $book->photo) }}" style="width: 250px" />
        @else
            <img src="{{ asset('images/book-default.png') }}" style="width: 250px" />
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
        <div
            class="d-flex justify-content-between align-items-center me-3 mb-1"
        >
            <h2 class="mb-3 title-color">{{ $book->title }}</h2>
            <div>
                <button
                    class="btn me-1"
                    style="background-color: #05111d; color: #e2ba76"
                >
                    <i class="bi bi-pen"></i>
                </button>
                <button
                    class="btn ms-1"
                    style="background-color: #7b3b3b; color: #e2ba76"
                >
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
        <x-desc label="Book Number" content="{{ $book->book_number }}" />
        <x-desc label="Author" content="{{ $book->author }}" />
        <x-desc label="Publisher" content="{{ $book->publisher }}" />
        <x-desc label="ISBN" content="{{ $book->isbn }}" />
        <x-desc label="Genre" content="{{ $book->genre }}" />
        <x-desc label="Publish Date" content="{{ $book->publish_date }}" />
        <x-desc label="Synopsis" content="{{ $book->synopsis }}" />
        <div class="d-flex justify-content-end pe-2">
            <x-dark-button class="btn btn-sm" onclick="window.history.back()">
                <i class="bi bi-arrow-left"></i> Back
            </x-dark-button>
        </div>
    </div>
</div>
