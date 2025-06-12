<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $books = collect();
        $notFound = false;

        if ($search) {
            $books = Book::where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%")
                ->paginate(20)
                ->appends(['search' => $search]);

            if ($books->isEmpty()) {
                $notFound = true;
                $books = [];
            }
        } else {
            $books = Book::paginate(20);
        }

        return view('books.index')->with([
            'books' => $books,
            'notFound' => $notFound,
            'search' => $search,
        ]);
    }

    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Book::class)) {
            return response()->view('errors.403', [], 403);
        }
        return view('books.create');
    }

    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Book::class)) {
            return response()->view('errors.403', [], 403);
        }

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
            try {
                $file = $request->file('photo');
                $response = Http::asMultipart()->post(
                    'https://api.cloudinary.com/v1_1/' . env('CLOUDINARY_CLOUD_NAME') . '/image/upload',
                    [
                        [
                            'name'     => 'file',
                            'contents' => fopen($file->getRealPath(), 'r'),
                            'filename' => $file->getClientOriginalName(),
                        ],
                        [
                            'name'     => 'upload_preset',
                            'contents' => env('CLOUDINARY_UPLOAD_PRESET'),
                        ],
                    ]
                );

                $result = $response->json();
                if (isset($result['secure_url'])) {
                    $validated['photo'] = $result['secure_url'];
                } else {
                    return back()->withErrors(['photo' => 'Cloudinary upload error: ' . ($result['error']['message'] ?? 'Unknown error')]);
                }
            } catch (\Exception $e) {
                return back()->withErrors(['photo' => 'Cloudinary error: ' . $e->getMessage()]);
            }
        }

        $validated['availability'] = true;

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Books successfully added');
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        $reviews = $book->reviews()->with('user')->get();
        return view('books.show', compact('book', 'reviews'));
    }

    public function edit(Request $request, Book $book)
    {
        if ($request->user()->cannot('update', $book)) {
            return response()->view('errors.403', [], 403);
        }
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        if ($request->user()->cannot('update', $book)) {
            return response()->view('errors.403', [], 403);
        }

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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'remove_photo' => 'nullable|in:1',
        ]);

        if ($request->input('remove_photo') == '1') {
            $validated['photo'] = null;
        }

        if ($request->hasFile('photo')) {
            try {
                $file = $request->file('photo');
                $response = Http::asMultipart()->post(
                    'https://api.cloudinary.com/v1_1/' . env('CLOUDINARY_CLOUD_NAME') . '/image/upload',
                    [
                        [
                            'name'     => 'file',
                            'contents' => fopen($file->getRealPath(), 'r'),
                            'filename' => $file->getClientOriginalName(),
                        ],
                        [
                            'name'     => 'upload_preset',
                            'contents' => env('CLOUDINARY_UPLOAD_PRESET'),
                        ],
                    ]
                );

                $result = $response->json();
                if (isset($result['secure_url'])) {
                    $validated['photo'] = $result['secure_url'];
                } else {
                    return back()->withErrors(['photo' => 'Cloudinary upload error: ' . ($result['error']['message'] ?? 'Unknown error')]);
                }
            } catch (\Exception $e) {
                return back()->withErrors(['photo' => 'Cloudinary error: ' . $e->getMessage()]);
            }
        } elseif (!isset($validated['photo'])) {
            $validated['photo'] = $book->photo;
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book successfully updated');
    }

    public function destroy(Request $request, Book $book)
    {
        if ($request->user()->cannot('delete', $book)) {
            return response()->view('errors.403', [], 403);
        }

        try {
            // Delete photo if exists
            if ($book->photo && file_exists(public_path('images/' . $book->photo))) {
                unlink(public_path('images/' . $book->photo));
            }

            $book->delete();

            return redirect()->route('books.index')->with('success', 'Book successfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            // Catch foreign key constraint error
            return redirect()->route('books.index')
                ->with('error', 'Failed to delete! The book is currently on loan.');
        }
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
