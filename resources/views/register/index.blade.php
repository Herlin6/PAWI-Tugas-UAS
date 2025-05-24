{{-- <x-input-text name="username" label="Username" /> --}}

@extends('layout.auth') @section('title', 'Register') @section('content')

<div class="text-center mb-3 container">
    <img src="{{ asset('assets/img/GDeBookLogo2.png') }}" alt="GDeBook Logo Register" width="200">
    <h3 class="sub-title-color font-playfair mb-4">Create Your Account</h3>
    
    <form action="" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 1000px;">
        @csrf

        <div class="mb-3 text-start">
            <label for="nama" class="form-label font-playfair main-color">Full Name</label>
            <input type="text" name="nama" id="nama" class="form-control form-theme border-0" placeholder="Enter your full name">
        </div>

        <div class="mb-3 text-start">
            <label for="email" class="form-label font-playfair main-color">Email</label>
            <input type="email" name="email" id="email" class="form-control form-theme border-0" required placeholder="Enter your email">
        </div>

        <div class="mb-3 text-start">
            <label for="tanggal_lahir" class="form-label font-playfair main-color">Date Of Birth</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control form-theme border-0" required>
        </div>

        <div class="mb-3 text-start">
            <label for="password" class="form-label font-playfair main-color">Password</label>
            <input type="password" name="password" id="password" class="form-control form-theme border-0" required placeholder="Create a password">
        </div>

        <div class="mb-3 text-start">
            <label for="alamat" class="form-label font-playfair main-color">Address</label>
            <input type="text" name="alamat" id="alamat" class="form-control form-theme border-0" required placeholder="Enter your full address">
        </div>

        <div class="mb-3 text-start">
            <label for="pekerjaan" class="form-label font-playfair main-color">Employment</label>
            <input type="text" name="pekerjaan" id="pekerjaan" class="form-control form-theme border-0" required placeholder="Enter your employment">
        </div>

        <div class="mb-3 text-start">
            <label for="foto" class="form-label font-playfair main-color">Profil Photo</label>
            <input type="file" name="foto" id="foto" class="form-control form-theme border-0">
        </div>

        <div class="d-flex justify-content-between">
            <button type="button" class="btn main-bg-body text-white">Cancel</button>
            <button type="submit" class="btn btn-theme">Register Now</button>
        </div>
    </form>
</div>

@endsection