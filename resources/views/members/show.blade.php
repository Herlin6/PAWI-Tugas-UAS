@extends('layout.general')
@section('content')

    <div class="container" style="overflow-x: hidden;">
        <div class="container py-2 ms-lg-2 d-flex justify-content-between align-items-center flex-lg-row flex-column">
            <h1 class="mb-3 title-color">{{ $member->user->name }}</h1>
            <x-action-button
                :onEdit="'window.location.href=`' . route('members.edit', $member->id) . '`'"
                :onDelete="'document.getElementById(\'delete-member-form\').submit()'"
            />
            <form id="delete-member-form" action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
        <div class="d-flex justify-content-between align-items-center flex-lg-row flex-column align-items-lg-start">
            <div class="text-center p-4 pt-0" data-aos="fade-right" data-aos-duration="500">
                @if ($member->photo && file_exists(public_path($member->photo)))
                    <img src="{{ $member->photo }}" style="width: 200px">
                @else
                    <img src="{{ asset('images/default.png') }}" style="width: 200px">
                @endif
                <div>
                    @if ($member->borrowing == 1)
                        <div class="badge main-bg-body g-text-success w-100 p-3 rounded-3 text-center mt-3 fs-6">
                            Borrowing
                        </div>
                    @else
                        <div class="badge main-bg-body g-text-danger w-100 p-3 rounded-3 text-center mt-3 fs-6">
                            Not Borrowing
                        </div>
                    @endif
                </div>
            </div>
            <div class="w-100">
                <div data-aos="fade-left" data-aos-duration="400">
                    <x-desc label="Number" content="{{ $member->member_number }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="4500">
                    <x-desc label="Email" content="{{ $member->user->email }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="600">
                    <x-desc label="Date of Birth" content="{{ $member->date_of_birth->format('Y-m-d') }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="700">
                    @if ($member->gender == "M")
                        <x-desc label="Gender" content="Male" />
                    @else
                        <x-desc label="Gender" content="Female" />
                    @endif
                </div>
                <div data-aos="fade-left" data-aos-duration="800">
                    <x-desc label="Address" content="{{ $member->address }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="900">
                    <x-desc label="Handphone" content="{{ $member->handphone }}" />
                </div>
                <div data-aos="fade-left" data-aos-duration="1000">
                    <x-desc label="Employment" content="{{ $member->employment }}" />
                </div>
                <div class="d-flex justify-content-end pe-2">
                    <x-dark-button class="btn btn-sm" href="{{ route('members.index') }}">
                        <i class="bi bi-arrow-left"></i> Back
                    </x-dark-button>
                </div>
            </div>
        </div>
    </div>

@endsection