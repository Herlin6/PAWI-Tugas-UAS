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
                        label="Member"
                        name="member_id"
                        type="select"
                        :options="$members->mapWithKeys(function($member) {
                            $label = $member->user->name . ' (' . $member->user->email . ')';
                            return [$member->id => $label];
                        })->toArray()"
                        required="true"
                        placeholder="Select Member"
                        :selected="old('member_id')"
                        :errorMessage="$errors->first('member_id')"
                    />
                    <x-input-option
                        label="Book Title"
                        name="book_id"
                        type="select"
                        :options="$books->pluck('title', 'id')->toArray()"
                        required="true"
                        placeholder="Select Book"
                        :selected="old('book_id')"
                        :errorMessage="$errors->first('book_id')"
                    />
                    <x-input-text
                        inRowLabel="Borrow Date"
                        name="borrow_date"
                        type="date"
                        required="true"
                        :value="old('borrow_date')"
                        :errorMessage="$errors->first('borrow_date')"
                    />
                    <x-input-text
                        inRowLabel="Length of Loan (days)"
                        name="length_of_loan"
                        type="number"
                        min="1"
                        required="true"
                        :value="old('length_of_loan')"
                        :errorMessage="$errors->first('length_of_loan')"
                    />
                </div>

                <div class="form-buttons">
                    <div class="d-flex justify-content-between mt-4">
                        <x-dark-button onclick="window.location.href='{{ route('loans.index') }}'" type="button">
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
