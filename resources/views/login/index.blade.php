@extends('layout.auth') @section('title', 'Login') @section('content') @section('class-body', "overflow-hidden")

<div class="font-playfair sub-title-color p-lg-0 p-3" >
    <div class="row g-0 vh-100 w-100">
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="w-100" style="max-width: 400px">
                <div class="text-center mb-4">
                    <img
                        src="assets/img/GDeBookLogo2.png"
                        alt="Logo GDeBook"
                        style="max-width: 140px"
                    />
                    <h4>LOGIN</h4>
                </div>
                <form method="POST" action="login">
                    @csrf

                    <x-input-text
                        name="email"
                        label="Email"
                        type="email"
                        placeholder="Enter your email"
                        class="mb-3"
                    />
                    <x-input-text
                        name="password"
                        label="Password"
                        type="password"
                        placeholder="Enter your password"
                        class="mb-4"
                    />

                    <div class="mt-5">
                        <x-button type="submit" class="btn btn-theme w-100">
                            Login
                        </x-button>
                    </div>
                    <div class="text-center mt-3">
                        <span>Don't have an account? </span>
                        <a href="{{ url('/register') }}" class="sub-title-color">
                            Register
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6 d-none d-lg-block">
            <div class="h-100 w-100">
                <img
                    src="assets/img/foto-login.jpg"
                    alt="Library"
                    class="img-fluid w-100 h-100 d-block object-fit-cover"
                />
            </div>
        </div>
    </div>
</div>

@endsection
