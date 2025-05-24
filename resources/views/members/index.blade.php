@extends('layout.main')
@section('title', 'Manage Members')
@section('content')

<div class="container">
    <form method="GET" action="{{ route('members.index') }}" class="d-flex align-items-center gap-2">
        <input
            type="text"
            class="form-control form-theme"
            id="search"
            name="search"
            placeholder="Search by name or email"
            value="{{ request('search') }}"
            autocomplete="off"
        >
        <button type="button" id="clearBtn" class="btn btn-theme" style="padding: 1rem">
            Clear
        </button>
    </form>
    
    <div class="mt-4">
        <a href="/" class="btn btn-theme">
            Add Member
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