@extends('layout.main')
@section('title', 'Edit Book')
@section('content')
<div class="container form-container" style="overflow-x: hidden">
    <form method="POST" action="{{ route('books.update', $book->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="d-flex justify-content-between align-items-center flex-lg-row flex-column align-items-lg-start">
            <div class="text-center p-4 pt-0 d-flex flex-column justify-content-center align-items-center">
                <label
                    for="photo"
                    class="text-center border-dark-gold p-3 font-playfair bg-body-secondary d-flex flex-column align-items-center justify-content-between"
                    style="width: 140px; height: 210px; display: inline-block; cursor: pointer; position: relative;"
                >
                    <img
                        id="preview-img"
                        src="{{ $book->photo && file_exists(public_path($book->photo)) 
                                ? asset($book->photo) 
                                : asset('images/book-default.png') }}"
                        alt="Preview"
                        style="width:100%; height:120px; object-fit:cover; border-radius:4px;"
                    />

                    <div id="photo-preview" class="mt-2 text-center">
                        @if ($book->photo && file_exists(public_path($book->photo)))
                            <div class="main-color" id="photo-instruction">Click to upload photo</div>
                        @else
                            <div class="main-color" id="photo-instruction">Click to upload photo</div>
                        @endif
                    </div>
                </label>

                <input
                    type="file"
                    name="photo"
                    id="photo"
                    class="d-none"
                    accept="image/*"
                    onchange="previewPhoto(event)"
                />

                @error('photo')
                    <div class="g-text-danger font-playfair mt-1">{{ $message }}</div>
                @enderror

                <button
                    type="button"
                    id="remove-photo-btn"
                    class="btn btn-sm btn-outline-danger mt-2 g-text-danger"
                    style="{{ $book->photo ? 'display:inline-block;' : 'display:none;' }}"
                    onclick="removePhoto()"
                >Remove File</button>
                <input type="hidden" name="remove_photo" id="remove-photo-flag" value="0">
            </div>

            <div class="w-100">
                <div data-aos="fade-left" data-aos-duration="400">
                    <x-input-text inRowLabel="Book Number" name="book_number" required="true" placeholder="Enter number" value="{{ old('book_number') ?? $book->book_number }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="500">
                    <x-input-text inRowLabel="Title" name="title" required="true" placeholder="Enter title" value="{{ old('title') ?? $book->title }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="600">
                    <x-input-text inRowLabel="Author" name="author" required="true" placeholder="Enter author" value="{{ old('author') ?? $book->author }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="700">
                    <x-input-text inRowLabel="Publisher" name="publisher" required="true" placeholder="Enter publisher" value="{{ old('publisher') ?? $book->publisher }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="800">
                    <x-input-text inRowLabel="ISBN" name="isbn" required="true" placeholder="Enter ISBN" value="{{ old('isbn') ?? $book->isbn }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="900">
                    <x-input-option label="Genre" name="genre" type="select" :options="[
                        'Fiction' => 'Fiction',
                        'Non-Fiction' => 'Non-Fiction',
                        'Science' => 'Science',
                        'Technology' => 'Technology',
                        'History' => 'History',
                        'Literature' => 'Literature',
                        ]" required="true" placeholder="Select genre" :value="old('genre', $book->genre)" />
                    @php 
                        use Carbon\Carbon; 
                        $publishDate = old('publish_date') ?: $book->publish_date; 
                        $publishDate = $publishDate ? Carbon::parse($publishDate)->format('Y-m-d') : ''; 
                    @endphp
                </div>
                <div data-aos="fade-left" data-aos-duration="1000">
                    <x-input-text inRowLabel="Publish Date" name="publish_date" type="date" required="true" value="{{ $publishDate }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="1100">
                    <x-input-text-area label="Synopsis" name="synopsis" type="textarea" rows="3" required="true" placeholder="Enter synopsis" value="{{ old('synopsis') ?? $book->synopsis }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="1200">
                    <x-input-option label="Availability" name="availability" type="select" :options="[1 => 'Available', 0 => 'Not Available']" required="true" :value="old('availability', $book->availability)" />
                </div>
                
                <div class="form-buttons mt-4 d-flex justify-content-between" data-aos="fade-left" data-aos-duration="1300">
                    <x-dark-button href="{{ route('books.index') }}"><i class="bi bi-arrow-left"></i> Back</x-dark-button>
                    <x-button type="submit">Update Book</x-button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewPhoto(event) {
    const input = event.target;
    const previewImg = document.getElementById('preview-img');
    const instruction = document.getElementById('photo-instruction');
    const note = document.getElementById('photo-note');
    const removeBtn = document.getElementById('remove-photo-btn');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);

        if (instruction) instruction.style.display = 'none';
        if (note) note.style.display = 'none';
        if (removeBtn) removeBtn.style.display = 'inline-block';
    }
}

function removePhoto() {
    const input = document.getElementById('photo');
    const previewImg = document.getElementById('preview-img');
    const instruction = document.getElementById('photo-instruction');
    const note = document.getElementById('photo-note');
    const removeBtn = document.getElementById('remove-photo-btn');
    const removePhotoFlag = document.getElementById('remove-photo-flag');

    input.value = '';
    previewImg.src = "{{ asset('images/book-default.png') }}";
    if (instruction) instruction.style.display = '';
    if (note) note.style.display = '';
    if (removeBtn) removeBtn.style.display = 'none';

    if (removePhotoFlag) removePhotoFlag.value = "1";
}

</script>
@endsection
