@extends('layout.auth')
@section('title', 'Login')
@section('class-body', "overflow-hidden")
@section('content')

<div class="font-playfair sub-title-color p-lg-0 p-3 d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="w-100 text-center">
        <h1 class="display-1 g-text-danger">403</h1>
        <h2 class="mb-4">Forbidden</h2>
        <p class="lead mb-4">You do not have permission to access this page.</p>
        <x-dark-button href="{{ url()->previous() }}">Back</x-dark-button>
        <x-button href="{{ route('dashboard') }}">Dashboard</x-button>
    </div>
</div>

@endsection
