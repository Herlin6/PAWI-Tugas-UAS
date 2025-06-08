@extends('layout.user')
@section('content')

<div class="container">
    <h1 class="text-center mb-4 title-color">Welcome to the GDeBook Library</h1>
    <p class="text-center sub-title-color">Here you can lorem ipsum dolor sit amet</p>
    <form method="POST" action="{{ route('logout') }}" class="text-center mt-4">
        @csrf
        <x-dark-button type="submit">
            {{ __('Log Out') }}
        </x-dark-button>
    </form>

</div>

@endsection
