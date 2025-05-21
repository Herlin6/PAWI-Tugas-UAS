@extends('layout.main') @section('content') @section('title', 'Welcome, Admin!')
<div class="container">
    @include('home.partials.stats-cards')
    @include('home.partials.daily-loan-stats')
</div>

@endsection
