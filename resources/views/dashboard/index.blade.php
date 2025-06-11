@extends('layout.main') @section('content') @section('title', 'Welcome ' . Auth::user()->name)
<div class="container">
    <div data-aos="fade-down">
        @include('dashboard.partials.stats-cards')
    </div>
    @include('dashboard.partials.top-books-chart')
</div>

@endsection
