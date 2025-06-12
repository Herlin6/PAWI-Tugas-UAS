
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
                        class="py-3"
                        data-aos="zoom-in" data-aos-duration="400"
                    />
                    <h4 data-aos="zoom-in" data-aos-duration="500">LOGIN</h4>
                </div>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <x-input-text
                        name="email"
                        label="Email"
                        type="email"
                        placeholder="Enter your email"
                        autocomplete="username"
                        required
                        autofocus
                        class="mb-3"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    <x-input-text
                        name="password"
                        label="Password"
                        type="password"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                        class="mb-3"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    {{-- <div class="block mt-4 sub-title-color">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif --}}

                    <div class="mt-5">
                        <x-button type="submit" class="btn btn-theme w-100">
                            <div class="font-playfair">{{ __('Login') }}</div>
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
