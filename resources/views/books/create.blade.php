@extends('layout.main') 
@section('title', 'Add Book') 
@section('content')

<div class="container">
    <form
        method="POST"
        action="{{ route('books.store') }}"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="d-flex justify-content-between align-items-center flex-lg-row flex-column align-items-lg-start">
            <div class="text-center p-4 pt-0 d-flex flex-column">
                <label
                    for="photo"
                    class="text-center border-dark-gold p-3 font-playfair bg-body-secondary"
                    style="width: 140px; height: 180px; display: inline-block; cursor: pointer;"
                >
                    <div id="photo-preview">
                        <div class="main-color" id="photo-instruction">Click to upload photo</div>
                        <br id="photo-br">
                        <div class="text-muted" id="photo-note">
                            jpeg,png,jpg,gif<br />max:2048kb
                        </div>
                    </div>
                    <img
                        id="preview-img"
                        src="#"
                        alt="Preview"
                        style="display:none; width:100%; height:100px; max-height:100px; object-fit:contain; margin-top:10px; margin-left:0;"
                    />
                    <div
                        id="file-name"
                        class="main-color mt-2"
                        style="font-size: 0.9em; max-width: 120px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; white-space: normal; text-overflow: ellipsis; word-break: break-all;"
                    ></div>
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
                        style="display:none;"
                        onclick="removePhoto()"
                    >Remove File</button>
            </div>
            <div class="w-100">
                <x-input-text
                    inRowLabel="Book Number"
                    name="book_number"
                    required="true"
                    placeholder="Enter number"
                    :value="old('book_number')"
                    :errorMessage="$errors->first('book_number')"
                />

                <x-input-text
                    inRowLabel="Title"
                    name="title"
                    required="true"
                    placeholder="Enter title"
                    :value="old('title')"
                    :errorMessage="$errors->first('title')"
                />

                <x-input-text
                    inRowLabel="Author"
                    name="author"
                    required="true"
                    placeholder="Enter author"
                    :value="old('author')"
                    :errorMessage="$errors->first('author')"
                />

                <x-input-text
                    inRowLabel="Publisher"
                    name="publisher"
                    required="true"
                    placeholder="Enter publisher"
                    :value="old('publisher')"
                    :errorMessage="$errors->first('publisher')"
                />

                <x-input-text
                    inRowLabel="ISBN"
                    name="isbn"
                    required="true"
                    placeholder="Enter ISBN"
                    :value="old('isbn')"
                    :errorMessage="$errors->first('isbn')"
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
                    placeholder="Enter genre"
                    :selected="old('genre')"
                    :errorMessage="$errors->first('genre')"
                />

                <x-input-text
                    inRowLabel="Publish Date"
                    name="publish_date"
                    type="date"
                    required="true"
                    :value="old('publish_date')"
                    :errorMessage="$errors->first('publish_date')"
                />

                <x-input-text-area
                    label="Synopsis"
                    name="synopsis"
                    rows="3"
                    required="true"
                    placeholder="Enter synopsis"
                    :errorMessage="$errors->first('synopsis')"
                />

                <div class="d-flex justify-content-between pe-2 mt-4">
                    <x-dark-button onclick="window.location.href='{{ route('books.index') }}'" type="button" class="me-2">
                        <i class="bi bi-arrow-left"></i> Back
                    </x-dark-button>
                    <x-button type="submit">
                        Add Book
                    </x-button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewPhoto(event) {
    const input = event.target;
    const previewImg = document.getElementById('preview-img');
    const fileNameDiv = document.getElementById('file-name');
    const instruction = document.getElementById('photo-instruction');
    const note = document.getElementById('photo-note');
    const br = document.getElementById('photo-br');
    const removeBtn = document.getElementById('remove-photo-btn');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
        // Format file name: max 2 lines, ellipsis if too long
        let name = input.files[0].name;
        if (name.length > 40) {
            name = name.substring(0, 37) + '...';
        }
        fileNameDiv.textContent = name;
        fileNameDiv.title = input.files[0].name;
        if (instruction) instruction.style.display = 'none';
        if (note) note.style.display = 'none';
        if (br) br.style.display = 'none';
        if (removeBtn) removeBtn.style.display = 'inline-block';
    } else {
        previewImg.style.display = 'none';
        fileNameDiv.textContent = '';
        fileNameDiv.title = '';
        if (instruction) instruction.style.display = '';
        if (note) note.style.display = '';
        if (br) br.style.display = '';
        if (removeBtn) removeBtn.style.display = 'none';
    }
}

function removePhoto() {
    const input = document.getElementById('photo');
    const previewImg = document.getElementById('preview-img');
    const fileNameDiv = document.getElementById('file-name');
    const instruction = document.getElementById('photo-instruction');
    const note = document.getElementById('photo-note');
    const br = document.getElementById('photo-br');
    const removeBtn = document.getElementById('remove-photo-btn');
    input.value = '';
    previewImg.style.display = 'none';
    fileNameDiv.textContent = '';
    fileNameDiv.title = '';
    if (instruction) instruction.style.display = '';
    if (note) note.style.display = '';
    if (br) br.style.display = '';
    if (removeBtn) removeBtn.style.display = 'none';
}
</script>

@endsection
