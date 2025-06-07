@extends('layout.main') @section('title', 'Edit Member') @section('content')
<div class="container form-container">
    <form
        method="POST"
        action="{{ route('members.update', $member->id) }}"
        enctype="multipart/form-data"
    >
        @csrf @method('PUT')

        <div
            class="d-flex justify-content-between align-items-start flex-lg-row flex-column"
        >
            <div class="text-center p-4 pt-0">
                <div class="mb-3 d-flex flex-column align-items-center">
                    @if ($member->photo && file_exists(public_path('images/' .
                    $member->photo)))
                    <img
                        src="{{ asset('images/' . $member->photo) }}"
                        style="width: 250px"
                    />
                    @else
                    <img
                        src="{{ asset('images/default.png') }}"
                        style="width: 250px"
                    />
                    @endif
                    <input
                        type="file"
                        name="photo"
                        id="photo"
                        class="form-control form-control-sm mt-2"
                    />
                    @error('photo')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="w-100">
                <x-input-text
                    inRowLabel="Number"
                    name="member_number"
                    required="true"
                    placeholder="Enter member number"
                    value="{{ old('member_number') ? old('member_number') : $member->member_number }}"
                />
                <x-input-text
                    inRowLabel="Name"
                    name="name"
                    required="true"
                    placeholder="Enter name"
                    value="{{ old('name') ? old('name') : $member->name }}"
                />
                <x-input-text
                    inRowLabel="Email"
                    name="email"
                    required="true"
                    placeholder="Enter email"
                    value="{{ old('email') ? old('email') : $member->email }}"
                />
                @php use Carbon\Carbon; $dateofbirth = old('date_of_birth') ?:
                $member->date_of_birth; $dateofbirth = $dateofbirth ?
                Carbon::parse($dateofbirth)->format('Y-m-d') : ''; @endphp
                <x-input-text
                    inRowLabel="Date of Birth"
                    name="date_of_birth"
                    type="date"
                    required="true"
                    value="{{ $dateofbirth }}"
                />
                <x-input-option
                    label="Gender"
                    name="gender"
                    type="select"
                    :options="[
                        'F' => 'Female',
                        'M' => 'Male',
                    ]"
                    required="true"
                    placeholder="Select gender"
                    :value="old('gender', $member->gender)"
                />
                <x-input-text-area
                    label="Address"
                    name="address"
                    type="textarea"
                    rows="3"
                    required="true"
                    placeholder="Enter address"
                    value="{{ old('address') ? old('address') : $member->address }}"
                />
                <x-input-text
                    inRowLabel="Handphone"
                    name="handphone"
                    required="true"
                    placeholder="Enter handphone"
                    value="{{ old('handphone') ? old('handphone') : $member->handphone }}"
                />
                <x-input-text
                    inRowLabel="Employment"
                    name="employment"
                    required="true"
                    placeholder="Enter employment"
                    value="{{ old('employment') ? old('employment') : $member->employment }}"
                />
            </div>
        </div>
        <div class="form-buttons mt-4 d-flex justify-content-between">
            <x-dark-button onclick="window.history.back()">
                <i class="bi bi-arrow-left"></i> Back
            </x-dark-button>
            <x-button type="submit">Update Member</x-button>
        </div>
    </form>
</div>
@endsection
