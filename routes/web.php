<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
});

Route::get('/register', function () {
    return view('register.index');
});

// Route::get('/', [HomeController::class, 'index']);
Route::resource('/books', BookController::class);
Route::resource('/loans', LoanController::class);
Route::resource('/members', MemberController::class);
