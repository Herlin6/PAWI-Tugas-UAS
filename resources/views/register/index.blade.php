@extends('layout.auth') @section('title', 'Register') @section('content')

<div class="text-center mb-3 container">
    <img src="{{ asset('assets/img/GDeBookLogo2.png') }}" alt="GDeBook Logo Register" width="200">
    <h3 class="sub-title-color font-playfair mb-4">Create Your Account</h3>
    
    <form action="" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 1000px;">
        @csrf

        <x-input-text name="fullname" label="Full Name" placeholder="Enter your full name" />
        <x-input-text name="email" label="Email" placeholder="Enter your email" type="email" />
        <x-input-text name="birth" label="Date of Birth" placeholder="Enter your date of birth" type="date"/>
        <x-input-text name="password" label="Password" placeholder="Enter your password" type="password" />
        <x-input-text name="address" label="Address" placeholder="Enter your address" />
        <x-input-text name="employment" label="Employment" placeholder="Enter your employment" />

        <div class="mb-3 text-start">
            <label for="photo" class="form-label font-playfair main-color">Profil Photo</label><br/>
            <label for="photo" class="btn border p-4 font-playfair">
                <div class="main-color">Click to upload photo</div>
                <div>jpeg,png,jpg,gif<br/>max:2048kb</div>
            </label>
            <input type="file" name="photo" id="photo" class="d-none">
        </div>



        <div class="d-flex justify-content-between">
            <button type="button" class="btn main-bg-body text-white">Cancel</button>
            <button type="submit" class="btn btn-theme">Register Now</button>
        </div>
    </form>
</div>

@endsection