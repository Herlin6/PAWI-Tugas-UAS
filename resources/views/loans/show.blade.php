@extends('layout.main')
@section('title', 'Loan Details')
@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-start flex-lg-row flex-column">
        <div class="w-100">
            <h2 class="mb-3 title-color">{{ ucfirst($loan->loan_status) }}</h2>

            <x-desc label="Member Name" content="{{ $loan->member->name }}" />
            <x-desc label="Book Title" content="{{ $loan->book->title }}" />
            <x-desc label="Borrow Date" content="{{ $loan->borrow_date }}" />
            <x-desc label="Due Date" content="{{ $loan->due_date }}" />
            <x-desc label="Loan Status" content="{{ ucfirst($loan->loan_status) }}" />
            <x-desc label="Return Date" content="{{ $loan->return_date ?? 'Not yet returned' }}" />

            <div class="d-flex justify-content-between mt-4">
                <x-action-button
                    :onEdit="'window.location.href=`' . route('books.edit', $loan->book->id) . '`'"
                    :onDelete="'document.getElementById(\'delete-loan-form\').submit()'"
                    dataName="Book"
                />
                <form id="delete-loan-form" action="{{ route('loans.destroy', $loan->id) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
                <x-dark-button class="btn btn-sm" onclick="window.history.back()">
                    <i class="bi bi-arrow-left"></i> Back
                </x-dark-button>
            </div>
        </div>
    </div>
</div>

@endsection
