<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    $user = Auth::user();
    if ($user->role === 'admin') {
        return app(DashboardController::class)->index();
    } else {
        return view('dashboard.user');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Books index: admin ke index, selain admin ke books.user
Route::get('/books', function (Request $request) {
    $user = Auth::user();
    if ($user && $user->role === 'admin') {
        return app(BookController::class)->index($request);
    } else {
        return app(BookController::class)->userIndex($request);
    }
})->middleware(['auth', 'verified'])->name('books.index');

// Members index: hanya admin yang bisa akses
Route::get('/members', function (Request $request) {
    $user = Auth::user();
    if ($user && $user->role === 'admin') {
        return app(MemberController::class)->index($request);
    } else {
        // Tampilkan halaman 403 jika bukan admin
        abort(403, 'Unauthorized');
    }
})->middleware(['auth', 'verified'])->name('members.index');

// Loans index: admin ke index, selain admin ke loans.user
Route::get('/loans', function (Request $request) {
    $user = Auth::user();
    if ($user && $user->role === 'admin') {
        return app(LoanController::class)->index($request);
    } else {
        return app(LoanController::class)->userIndex();
    }
})->middleware(['auth', 'verified'])->name('loans.index');

// Resource routes (tanpa index)
Route::resource('/books', BookController::class)->except(['index']);
Route::resource('/members', MemberController::class)->except(['index']);
Route::resource('/loans', LoanController::class)->except(['index']);

// Books user page (opsional, jika ingin akses langsung)
Route::get('/books-user', [BookController::class, 'userIndex'])->name('books.user');
Route::get('/members-user', [MemberController::class, 'userIndex'])->name('members.user');
Route::get('/loans-user', [LoanController::class, 'userIndex'])->name('loans.user');

// Reviews & profile
Route::resource('reviews', \App\Http\Controllers\ReviewController::class);
Route::patch('/loans/{loan}/return', [LoanController::class, 'markAsReturned'])->name('loans.return');
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::put('/loans/{loan}', [LoanController::class, 'update'])->name('loans.update');

require __DIR__.'/auth.php';
