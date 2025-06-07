<div
    class="d-flex align-items-center flex-lg-row flex-column align-items-lg-start"
>
    <div class="text-center p-4 pt-0">
        @if ($book->photo && file_exists(public_path('images/' . $book->photo)))
            <img src="{{ asset('images/' . $book->photo) }}" style="width: 200px" />
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
        <div
            class="d-flex justify-content-between align-items-center me-3 mb-1"
        >
            <h2 class="mb-3 title-color">{{ $book->title }}</h2>
            <x-action-button
                :onEdit="'window.location.href=`' . route('books.edit', $book->id) . '`'"
                :onDelete="'document.getElementById(\'delete-book-form\').submit()'"
            />
            <form id="delete-book-form" action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
        <x-desc label="Book Number" content="{{ $book->book_number }}" />
        <x-desc label="Author" content="{{ $book->author }}" />
        <x-desc label="Publisher" content="{{ $book->publisher }}" />
        <x-desc label="ISBN" content="{{ $book->isbn }}" />
        <x-desc label="Genre" content="{{ $book->genre }}" />
        <x-desc label="Publish Date" content="{{ $book->publish_date->format('Y-m-d') }}" />
        <x-desc label="Synopsis" content="{{ $book->synopsis }}" />
        <div class="d-flex justify-content-end pe-2">
            <x-dark-button class="btn btn-sm" href="{{ route('books.index') }}">
                <i class="bi bi-arrow-left"></i> Back
            </x-dark-button>
        </div>
    </div>
</div>
