<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalMembers = User::where('role', 'member')->count();
        $totalLoans = Loan::count();
        $topBooks = Book::select('title')
            ->withCount('loans')
            ->orderByDesc('loans_count')
            ->limit(5)
            ->get();

        $chartData = $topBooks->map(function($book) {
            return [$book->title, $book->loans_count];
        });

        return view('dashboard.index', [
            'chartData' => $chartData,
            'totalBooks' => $totalBooks,
            'totalMembers' => $totalMembers,
            'totalLoans' => $totalLoans
        ]);
    }
    
    public function userDashboard()
    {
        $topBooks = Book::select('title')
            ->withCount('loans')
            ->orderByDesc('loans_count')
            ->limit(5)
            ->get();

        $chartData = $topBooks->map(function($book) {
            return [$book->title, $book->loans_count];
        });

        return view('dashboard.user', ['chartData' => $chartData]);
    }
}
