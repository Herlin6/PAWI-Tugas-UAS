<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/books-user', [BookController::class, 'userIndex'])->name('books.user');
Route::resource('/books', BookController::class);
Route::resource('/loans', LoanController::class);
Route::resource('/members', MemberController::class);
Route::patch('/loans/{loan}/return', [LoanController::class, 'markAsReturned'])->name('loans.return');
require __DIR__.'/auth.php';
