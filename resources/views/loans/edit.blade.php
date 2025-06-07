@extends('layout.main') @section('title', 'Edit Loan') @section('content')
<div class="container form-container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form
        method="POST"
        action="{{ route('loans.update', $loan->id) }}"
        enctype="multipart/form-data"
    >
        @csrf @method('PUT')

        <div
            class="d-flex justify-content-between align-items-start flex-lg-row flex-column"
        >
            <div class="w-100">
                <x-input-option
                    label="Member"
                    name="member_id"
                    type="select"
                    :options="$members"
                    required="true"
                    placeholder="Select member"
                    :value="old('member_id', $loan->member_id)"
                />
                <x-input-option
                    label="Book"
                    name="book_id"
                    type="select"
                    :options="$books"
                    required="true"
                    placeholder="Select book"
                    :value="old('book_id', $loan->book_id)"
                />
                <x-input-text
                    inRowLabel="Borrow Date"
                    name="borrow_date"
                    type="date"
                    required="true"
                    value="{{ old('borrow_date', $loan->borrow_date ? \Carbon\Carbon::parse($loan->borrow_date)->format('Y-m-d') : '') }}"
                />
                <x-input-text
                    inRowLabel="Return Date"
                    name="return_date"
                    type="date"
                    required="true"
                    value="{{ old('return_date', $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('Y-m-d') : '') }}"
                />
                <x-input-text
                    inRowLabel="Due Date"
                    name="due_date"
                    type="date"
                    required="true"
                    value="{{ old('due_date', $loan->due_date ? \Carbon\Carbon::parse($loan->due_date)->format('Y-m-d') : '') }}"
                />
                <x-input-option
                    label="Loan Status"
                    name="loan_status"
                    type="select"
                    :options="['borrowed' => 'Borrowed', 'returned' => 'Returned']"
                    required="true"
                    placeholder="Select status"
                    :value="old('loan_status', $loan->loan_status)"
                />
                <div class="form-buttons mt-4 d-flex justify-content-between">
                    <x-dark-button href="{{ route('loans.index') }}">
                        <i class="bi bi-arrow-left"></i> Back
                    </x-dark-button>
                    <x-button type="submit">Update Loan</x-button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
