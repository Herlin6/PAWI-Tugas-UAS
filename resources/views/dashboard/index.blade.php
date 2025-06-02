@extends('layout.main') @section('content') @section('title', 'Welcome ' . Auth::user()->name)
<div class="container">
    @include('dashboard.partials.stats-cards')
    @include('dashboard.partials.daily-loan-stats')
</div>

@endsection
