@extends('layout.main') @section('title', 'Add Book') @section('content')
<div class="container form-container">
    <form
        method="POST"
        action="{{ route('books.store') }}"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="form-content">
            <div class="row">
                <div class="col-lg-2 text-center">
                    <div class="mb-3 text-center">
                        <label
                            for="photo"
                            class="text-center border-dark-gold p-3 font-playfair bg-body-secondary"
                            style="width: 140px; height: 180px"
                        >
                            <div class="main-color">Click to upload photo</div>
                            <br />
                            <div class="text-muted">
                                jpeg,png,jpg,gif<br />max:2048kb
                            </div>
                        </label>
                        <input
                            type="file"
                            name="photo"
                            id="photo"
                            class="d-none"
                        />
                    </div>
                </div>
                <div class="col-lg-10">
                    <x-input-text
                        inRowLabel="Book Number"
                        name="book_number"
                        required="true"
                        placeholder="Enter number"
                    />
                    <x-input-text
                        inRowLabel="Title"
                        name="title"
                        required="true"
                        placeholder="Enter title"
                    />
                    <x-input-text
                        inRowLabel="Author"
                        name="author"
                        required="true"
                        placeholder="Enter author"
                    />
                    <x-input-text
                        inRowLabel="Publisher"
                        name="publisher"
                        required="true"
                        placeholder="Enter publisher"
                    />
                    <x-input-text
                        inRowLabel="ISBN"
                        name="isbn"
                        required="true"
                        placeholder="Enter ISBN"
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
                    />
                    <x-input-text
                        inRowLabel="Publish Date"
                        name="publish_date"
                        type="date"
                        required="true"
                    />
                    <x-input-text-area
                        label="Synopsis"
                        name="synopsis"
                        type="textarea"
                        rows="3"
                        required="true"
                        placeholder="Enter synopsis"
                    />
                </div>

                <div class="form-buttons">
                    <div class="d-flex justify-content-between mt-4">
                        <x-dark-button onclick="window.history.back()">
                            <i class="bi bi-arrow-left"></i> Back
                        </x-dark-button>
                        <x-button type="submit">
                            Add Book
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
