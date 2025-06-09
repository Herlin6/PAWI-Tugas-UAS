<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return view('reviews.index', compact('reviews'));
    }

    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Review::class)) {
            return response()->view('errors.403', [], 403);
        }
        return view('reviews.create');
    }

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

        $existingReview = Review::where('book_id', $validated['book_id'])
                                ->where('user_id', $request->user()->id)
                                ->first();

        if ($existingReview) {
            return redirect()->route('books.show', $validated['book_id'])
                ->with('error', 'You have already submitted a review for this book.');
        }

        $validated['user_id'] = $request->user()->id;

        Review::create($validated);

        return redirect()->route('books.show', $validated['book_id'])
            ->with('success', 'Review created successfully.');
    }

    public function show(Request $request, Review $review)
    {
        if ($request->user()->cannot('view', $review)) {
            return response()->view('errors.403', [], 403);
        }
        return view('reviews.show', compact('review'));
    }

    public function edit(Request $request, Review $review)
    {
        if ($request->user()->cannot('update', $review)) {
            return response()->view('errors.403', [], 403);
        }
        return view('reviews.edit', compact('review'));
    }

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
