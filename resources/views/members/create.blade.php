@extends('layout.main') @section('title', 'Add Member') @section('content')
<div class="container form-container">
    <form
        method="POST"
        action="{{ route('members.store') }}"
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
                        inRowLabel="Number"
                        name="member_number"
                        required="true"
                        placeholder="Enter number"
                    />
                    <x-input-text
                        inRowLabel="Name"
                        name="name"
                        required="true"
                        placeholder="Enter name"
                    />
                    <x-input-text
                        inRowLabel="Email"
                        name="email"
                        type="email"
                        required="true"
                        placeholder="Enter email"
                    />
                    <x-input-text
                        inRowLabel="Date Of Birth"
                        name="date_of_birth"
                        type="date"
                        required="true"
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
                        placeholder="Enter gender"
                    />
                    <x-input-text
                        inRowLabel="Address"
                        name="address"
                        required="true"
                        placeholder="Enter address"
                    />
                    <x-input-text
                        inRowLabel="Handphone"
                        name="handphone"
                        required="true"
                        placeholder="Enter handphone"
                    />
                    <x-input-text
                        inRowLabel="Employment"
                        name="employment"
                        required="true"
                        placeholder="Enter employment"
                    />
                </div>

                <div class="form-buttons">
                    <div class="d-flex justify-content-between mt-4">
                        <x-dark-button onclick="window.history.back()">
                            <i class="bi bi-arrow-left"></i> Back
                        </x-dark-button>
                        <x-button type="submit">
                            Add Member
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
