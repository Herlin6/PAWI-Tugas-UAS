@extends('layout.user')
@section('content')

<div class="container">
    <x-search placeholder="Search by title or author" />

    <div class="mt-5">
        @if(empty($books))
            <div class="text-center text-muted my-5">
                Tidak ada buku yang tersedia.
            </div>
        @else
        <div class="d-flex flex-wrap justify-content-lg-start justify-content-center gap-lg-4 gap-3">
            @foreach($books as $item)
            <a
                href="{{ route('books.show', $item->id) }}"
                class="text-decoration-none"
            >
                <x-book-card class="p-2" style="width: 240px">
                    <div class="w-full text-center">
                        @if ($item->photo &&
                        file_exists(public_path('images/' . $item->photo)))
                        <img
                            src="{{ asset('images/' . $item->photo) }}"
                            alt="{{ $item->judul }}"
                            class="img-fluid mb-2 rounded"
                            style="height: 200px; object-fit: cover"
                        />
                        @else
                        <img
                            src="{{ asset('images/book-default.png') }}"
                            alt="{{ $item->judul }}"
                            class="img-fluid mb-2 rounded"
                            style="height: 200px; object-fit: cover"
                        />
                        @endif
                    </div>
                    <h6 class="fw-bold mt-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $item->title }}</h6>

                    {{-- <div class=">
                        <i class="bi bi-star-fill"></i> {{ $book->rating }}
                    </div> --}}
                </x-book-card>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</div>

@endsection
