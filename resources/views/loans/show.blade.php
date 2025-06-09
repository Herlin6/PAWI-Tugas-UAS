@extends('layout.general')
@section('content')

<div class="container px-md-5 py-4">
    <div class="d-flex px-lg-5 justify-content-between align-items-start flex-lg-row flex-column">
        <div class="w-100">
            <div class="d-flex justify-content-between align-items-center flex-row">
                <h1 class="mb-3 title-color">{{ ucfirst($loan->loan_status) }}</h1>
                <x-action-button
                :onEdit="'window.location.href=`' . route('books.edit', $loan->book->id) . '`'"
                :onDelete="'document.getElementById(\'delete-loan-form\').submit()'"
                dataName="Book"
                />
                <form id="delete-loan-form" action="{{ route('loans.destroy', $loan->id) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

            <x-desc label="Member Name" content="{{ $loan->member->user->name ?? '-' }}" />
            <x-desc label="Member Email" content="{{ $loan->member->user->email ?? '-' }}" />
            <x-desc label="Book Title" content="{{ $loan->book->title }}" />
            <x-desc label="Borrow Date" content="{{ $loan->borrow_date ? \Carbon\Carbon::parse($loan->borrow_date)->format('Y-m-d') : '-' }}" />
            <x-desc label="Due Date" content="{{ $loan->due_date ? \Carbon\Carbon::parse($loan->due_date)->format('Y-m-d') : '-' }}" />
            <x-desc label="Loan Status" content="{{ ucfirst($loan->loan_status) }}" />
            <x-desc label="Return Date" content="{{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('Y-m-d') : 'Not yet returned' }}" />

            <div class="d-flex justify-content-end mt-4">
                <x-dark-button class="btn btn-sm" href="{{ route('loans.index') }}">
                    <i class="bi bi-arrow-left"></i> Back
                </x-dark-button>
            </div>
        </div>
    </div>
</div>

@endsection
