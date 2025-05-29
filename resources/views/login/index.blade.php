@extends('layout.auth') @section('title', 'Login') @section('content')

<div class="font-playfair">
    <div class="row g-0">
        <div
            class="col-md-6 d-flex align-items-center justify-content-center"
            style="height: 100vh"
        >
            <div class="w-100" style="max-width: 400px">
                <div class="text-center mb-4">
                    <img
                        src="assets/img/GDeBookLogo2.png"
                        alt="Logo GDeBook"
                        style="max-width: 140px"
                    />
                    <h4 class="sub-title-color">LOGIN</h4>
                </div>

                <form method="POST" action="login">
                    @csrf

                    <x-input-text
                        name="email"
                        label="Email"
                        type="email"
                        placeholder="Enter your email"
                        class=""
                    />
                    <x-input-text
                        name="password"
                        label="Password"
                        type="password"
                        placeholder="Enter your password"
                    />

                    <div class="mt-4">
                        <button
                            type="submit"
                            class="btn btn-theme w-100"
                            style="height: 40px"
                        >
                            Login
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <span class="sub-title-color"
                            >Don't have an account?
                        </span>
                        <a href="{{ url('/register') }}" class="sub-title-color"
                            >Register</a
                        >
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6 d-none d-lg-block p-0">
            <div
                style="
                    position: relative;
                    width: 100%;
                    height: 100vh;
                    overflow: hidden;
                "
            >
                <img
                    src="assets/img/foto-login.jpg"
                    alt="Library"
                    style="
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    "
                />
            </div>
        </div>
    </div>
</div>

@endsection
