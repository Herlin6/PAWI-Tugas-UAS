<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $books = collect();
        $notFound = false;

        if ($search) {
            $books = Book::where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%")
                ->get();

            if ($books->isEmpty()) {
                $notFound = true;
                $books = [];
            }
        } else {
            $books = Book::all();
        }

        return view('books.index')->with([
            'books' => $books,
            'notFound' => $notFound,
            'search' => $search,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'title' => 'required|max:255',
        'author' => 'required|max:100',
        'publisher' => 'required|max:100',
        'isbn' => 'required|max:17',
        'genre' => 'required|max:50',
        'publish_date' => 'required|date',
        'synopsis' => 'required',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    // Generate book number
    $validated['book_number'] = 'BK-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
    
    // Set default availability
    $validated['availability'] = true;

    return redirect()->route('books.index')->with('success', 'Books successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
