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
            'book_number' => 'required|max:10|unique:books,book_number',
            'title' => 'required|max:255',
            'author' => 'required|max:100',
            'publisher' => 'required|max:100',
            'isbn' => 'required|max:17',
            'genre' => 'required|max:50',
            'publish_date' => 'required|date',
            'synopsis' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('images'), $photoName);
            $validated['photo'] = $photoName;
        }

        $validated['availability'] = true;
        
        Book::create($validated);

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
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
    */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'book_number' => 'required|max:10|unique:books,book_number,' . $book->id,
            'title' => 'required|max:255',
            'author' => 'required|max:100',
            'publisher' => 'required|max:100',
            'isbn' => 'required|max:17',
            'genre' => 'required|max:50',
            'publish_date' => 'required|date',
            'synopsis' => 'required',
            'availability' => 'required|in:1,0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Jika file baru diupload
        if ($request->hasFile('photo')) {
            // Hapus file lama jika ada
            if ($book->photo && file_exists(public_path('images/' . $book->photo))) {
                unlink(public_path('images/' . $book->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $validated['photo'] = $filename;

        } elseif ($request->input('remove_photo') == '1') {
            // Jika user menekan tombol "Remove File"
            if ($book->photo && file_exists(public_path('images/' . $book->photo))) {
                unlink(public_path('images/' . $book->photo));
            }

            $validated['photo'] = null;

        } else {
            // Tidak upload baru & tidak dihapus → tetap gunakan yang lama
            $validated['photo'] = $book->photo;
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book successfully updated');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Hapus file foto jika ada
        if ($book->photo && file_exists(public_path('images/' . $book->photo))) {
            unlink(public_path('images/' . $book->photo));
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book successfully deleted');
    }

    public function userIndex(Request $request)
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
        
        return view('books.user')->with([
            'books' => $books,
            'notFound' => $notFound,
            'search' => $search,
        ]);
    }

}
