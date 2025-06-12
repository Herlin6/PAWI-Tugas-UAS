@extends('layout.main')
@section('title', 'Manage Members')
@section('content')

<div class="container">
    <x-search placeholder="Search by name or email" />
    
    <div class="mt-4" data-aos="zoom-in" data-aos-duration="700">
        @can('create', App\Models\Member::class)
            <x-button href="{{ route('members.create') }}">
                Add Member
            </x-button>
        @endcan
    </div>

    <div class="mt-1">
        @php
            $columns = include resource_path('contents/member-table.php');
            $tableData = $members->map(function($member) {
                return [
                    'id' => $member->id,
                    'name' => $member->user->name ?? '-',
                    'email' => $member->user->email ?? '-',
                    'gender' => $member->gender,
                    'address' => $member->address,
                    'action' => '',
                ];
            });
        @endphp
        <x-table :columns="$columns" :data="$tableData" page="members" />
        <div class="mt-4 d-flex justify-content-center">
            {{ $members->links('pagination::custom-pagination') }}
        </div>
    </div>
    <script src="{{ asset('js/search.js') }}"></script>
</div>

@endsection