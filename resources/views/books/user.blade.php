@extends('layout.user')
@section('content')
<style>
    .book-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .book-card:hover {
        transform: scale(1.03);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
</style>

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
                class="text-decoration-none book-card"
            >
            @php
                $durations = [500, 600, 700, 800, 900];
                $duration = $durations[$loop->index % count($durations)];
            @endphp
                <x-book-card
                    class="p-2"
                    style="width: 240px"
                    data-aos="fade-up"
                    data-aos-duration="{{ $duration }}"
                >
                    <div class="w-full text-center">
                        @if ($item->photo && file_exists(public_path('images/' . $item->photo)))
                            <img
                                src="{{ asset('images/' . $item->photo) }}"
                                alt="{{ $item->judul }}"
                                class="img-fluid mb-2 rounded"
                                style="height: 230px; object-fit: cover"
                            />
                        @else
                            <img
                                src="{{ asset('images/book-default.png') }}"
                                alt="{{ $item->judul }}"
                                class="img-fluid mb-2 rounded"
                                style="height: 230px; object-fit: cover"
                            />
                        @endif
                    </div>

                    <h6 class="fw-bold mt-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $item->title }}
                    </h6>

                    {{-- Rating --}}
                    <div class="main-color">
                        <i class="bi bi-star-fill text-warning"></i>
                        {{ $item->reviews->count() > 0 ? number_format($item->reviews->avg('rate'), 1) : 'No rating yet.' }}
                    </div>

                    {{-- Availability --}}
                    @php
                        $isAvailable = $item->availability == 1;
                        $availabilityText = $isAvailable ? 'Available' : 'Not Available';
                        $availabilityClass = $isAvailable ? 'g-text-success' : 'g-text-danger';
                    @endphp
                    <div class="{{ $availabilityClass }}">
                        {{ $availabilityText }}
                    </div>
                </x-book-card>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</div>

@endsection
