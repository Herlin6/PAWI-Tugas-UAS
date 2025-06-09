@extends('layout.auth')
@section('title', 'Register')
@section('content')

<div class="text-center mb-3 container font-playfair">
    <img
        src="{{ asset('assets/img/GDeBookLogo2.png') }}"
        alt="GDeBook Logo Register"
        width="200"
        class="py-5"
    />
    <h3 class="sub-title-color mb-4">Create Your Account</h3>

    <form
        method="POST"
        action="{{ route('register') }}"
        class="mx-auto p-3"
        style="max-width: 600px"
    >
        @csrf

        <x-input-text
            id="name"
            name="name"
            type="text"
            :value="old('name')"
            label="Name"
            placeholder="Enter your full name"
            required
            autofocus
            autocomplete="name"
            class="mb-3"
        />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
        <x-input-text
            id="email"
            name="email"
            type="email"
            :value="old('email')"
            label="Email"
            placeholder="Enter your email"
            required
            autocomplete="username"
            class="mb-3"
        />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
        <x-input-text
            id="password"
            name="password"
            type="password"
            label="Password"
            placeholder="Enter your password"
            required
            autocomplete="new-password"
            class="mb-3"
        />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />

        <x-input-text
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            label="Confirm Password"
            placeholder="Confirm your password"
            required
            autocomplete="new-password"
            class="mb-3"
        />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

        <div class="d-flex justify-content-between">
            <a href="{{ url('/login') }}" class="btn main-bg-body text-white">
                Cancel
            </a>
            <x-button type="submit">
                <div class="font-playfair">{{ __("Register") }}</div>
            </x-button>
        </div>
    </form>
</div>

@endsection
