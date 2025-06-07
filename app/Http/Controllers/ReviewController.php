<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::all();
        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Review::class)) {
            return response()->view('errors.403', [], 403);
        }
        return view('reviews.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Review::class)) {
            return response()->view('errors.403', [], 403);
        }

        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'rate' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $validated['user_id'] = $request->user()->id;

        Review::create($validated);

        return redirect()->route('books.show', $validated['book_id'])
            ->with('success', 'Review created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Review $review)
    {
        if ($request->user()->cannot('view', $review)) {
            return response()->view('errors.403', [], 403);
        }
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Review $review)
    {
        if ($request->user()->cannot('update', $review)) {
            return response()->view('errors.403', [], 403);
        }
        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        if ($request->user()->cannot('update', $review)) {
            return response()->view('errors.403', [], 403);
        }

        $validated = $request->validate([
            'rate' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review->update($validated);

        return redirect()->route('books.show', $review->book_id)
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Review $review)
    {
        if ($request->user()->cannot('delete', $review)) {
            return response()->view('errors.403', [], 403);
        }
        $bookId = $review->book_id;
        $review->delete();
        return redirect()->route('books.show', $bookId)
            ->with('success', 'Review deleted successfully.');
    }
}
