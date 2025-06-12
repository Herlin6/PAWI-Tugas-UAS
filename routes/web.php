<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    if ($user->role === 'admin') {
        return app(DashboardController::class)->index();
    } else {
        return app(DashboardController::class)->userDashboard();
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/books', function (Request $request) {
    $user = Auth::user();
    if ($user && $user->role === 'admin') {
        return app(BookController::class)->index($request);
    } else {
        return app(BookController::class)->userIndex($request);
    }
})->middleware(['auth', 'verified'])->name('books.index');

Route::get('/members', function (Request $request) {
    $user = Auth::user();
    if ($user && $user->role === 'admin') {
        return app(MemberController::class)->index($request);
    } else {
        abort(403, 'Unauthorized');
    }
})->middleware(['auth', 'verified'])->name('members.index');

Route::get('/my-profile', function (Request $request) {
    return app(MemberController::class)->userIndex($request);
})->middleware(['auth', 'verified'])->name('members.profile');
Route::put('/my-profile/update', [MemberController::class, 'userUpdate'])->name('members.userUpdate')->middleware(['auth', 'verified']);

Route::get('/loans', function (Request $request) {
    $user = Auth::user();
    if ($user && $user->role === 'admin') {
        return app(LoanController::class)->index($request);
    } else {
        return app(LoanController::class)->userIndex($request);
    }
})->middleware(['auth', 'verified'])->name('loans.index');

Route::resource('/books', BookController::class)->except(['index']);
Route::resource('/members', MemberController::class)->except(['index']);
Route::resource('/loans', LoanController::class)->except(['index']);

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

Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

require __DIR__.'/auth.php';
