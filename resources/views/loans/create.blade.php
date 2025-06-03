@extends('layout.main') @section('title', 'Add Loan') @section('content')
<div class="container form-container">
    <form
        method="POST"
        action="{{ route('loans.store') }}"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="form-content">
            <div class="row">
                <div class="col-lg-10">
                    <x-input-option
                        label="Member Name"
                        name="member_id"
                        type="select"
                        :options="$members->pluck('name', 'id')->toArray()"
                        required="true"
                        placeholder="Select Member"
                    />
                    <x-input-option
                        label="Book Title"
                        name="book_id"
                        type="select"
                        :options="$books->pluck('title', 'id')->toArray()"
                        required="true"
                        placeholder="Select Book"
                    />
                    <x-input-text
                        inRowLabel="Borrow Date"
                        name="borrow_date"
                        type="date"
                        required="true"
                    />
                    <x-input-text
                        inRowLabel="Due Date"
                        name="due_date"
                        type="date"
                        required="true"
                    />
                </div>

                <div class="form-buttons">
                    <div class="d-flex justify-content-between mt-4">
                        <x-dark-button onclick="window.history.back()">
                            <i class="bi bi-arrow-left"></i> Back
                        </x-dark-button>
                        <x-button type="submit"> Add Loan </x-button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
