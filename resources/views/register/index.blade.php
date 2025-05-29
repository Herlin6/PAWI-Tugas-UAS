@extends('layout.auth') @section('title', 'Register') @section('content')

<div class="text-center mb-3 container font-playfair">
    <img src="{{ asset('assets/img/GDeBookLogo2.png') }}" alt="GDeBook Logo Register" width="200">
    <h3 class="sub-title-color mb-4">Create Your Account</h3>
    
    <form action="" method="POST" enctype="multipart/form-data" class="mx-auto p-3" style="max-width: 1000px;">
        @csrf

        <x-input-text class="mb-3" name="fullname" label="Full Name" placeholder="Enter your full name" />
        <x-input-text class="mb-3" name="email" label="Email" placeholder="Enter your email" type="email" />
        <x-input-text class="mb-3" name="dateofbirth" label="Date of Birth" placeholder="Enter your date of birth" type="date"/>
        <x-input-text class="mb-3" name="password" label="Password" placeholder="Enter your password" type="password" />
        <x-input-text class="mb-3" name="address" label="Address" placeholder="Enter your address" />
        <x-input-text class="mb-3" name="employment" label="Employment" placeholder="Enter your employment" />

        <div class="mb-3 text-start">
            <label for="photo" class="form-label">Profil Photo</label><br/>
            <label for="photo" class="text-center border-dark-gold p-4 rounded-2 bg-body-secondary">
                <div>Click to upload photo</div>
                <div class="text-muted">jpeg,png,jpg,gif<br/>max:2048kb</div>
            </label>
            <input type="file" name="photo" id="photo" class="d-none">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ url('/login') }}">
                <button type="button" class="btn main-bg-body text-white">Cancel</button>
            </a>
            <x-button type="submit">
                <div class="font-playfair"> Register Now </div>
            </x-button>
        </div>
    </form>
</div>

@endsection