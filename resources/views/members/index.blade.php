@extends('layout.main')
@section('title', 'Manage Members')
@section('content')

<div class="container">
    <x-search route="members.index" placeholder="Search by name or email" />
    
    <div class="mt-4">
        <a href="/">
            <x-button>
                Add Member
            </x-button>
        </a>
    </div>

    <div class="mt-1">
        @php
            $columns = include resource_path('contents/member-table.php');
        @endphp
        <x-table :columns="$columns" :data="$members" page="members" />
    </div>
    <script src="{{ asset('js/search.js') }}"></script>
</div>

@endsection