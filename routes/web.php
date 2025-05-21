<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
});

Route::get('/books', function () {
    return view('books.index');
});

Route::get('/members', function () {
    return view('members.index');
});

Route::get('/loans', function () {
    return view('loans.index');
});

// Route::get('/', [HomeController::class, 'index']);
// Route::resource('/books', BookController::class);
// Route::resource('/loans', LoanController::class);
// Route::resource('/members', MemberController::class);
