<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $topBooks = Book::select('title')
            ->withCount('loans')
            ->orderByDesc('loans_count')
            ->limit(5)
            ->get();

        // Format untuk chart.js: [["Book Title", jumlah_peminjaman], ...]
        $chartData = $topBooks->map(function($book) {
            return [$book->title, $book->loans_count];
        });

        return view('dashboard.index', [
            'chartData' => $chartData
        ]);
    }
}
