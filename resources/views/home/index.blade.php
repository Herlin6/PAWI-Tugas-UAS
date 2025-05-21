@extends('layout.main') @section('content') @section('title', 'Welcome, Admin!')
<div class="container mt-5">
    <div class="row justify-content-center gx-3 gap-lg-4 gap-3">
        <div class="col-lg-3 col-sm-10 p-2 card-theme">
            <div class="text-center border border-gold rounded p-4">
                <div>Total Books</div>
                <h1>1000</h1>
            </div>
        </div>
        <div class="col-lg-3 col-sm-10 p-2 card-theme">
            <div class="text-center border border-gold rounded p-4">
                <div>Total Members</div>
                <h1>650</h1>
            </div>
        </div>
        <div class="col-lg-3 col-sm-10 p-2 card-theme">
            <div class="text-center border border-gold rounded p-4">
                <div>Total Loans</div>
                <h1>320</h1>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <h3 class="sub-title-color">Daily Loan Statistics</h3>
    </div>
</div>

@endsection
