<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $notFound = false;
        $query = Loan::with(['book', 'member']);

        if ($search) {
            $query->whereHas('member', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        $results = $query->get();

        if ($search && $results->isEmpty()) {
            $notFound = true;
            $results = collect([]);
        }

        $loans = $results->map(function ($loan) {
            return [
                'id' => $loan->id,
                'book_title' => $loan->book->title ?? '-',
                'member_name' => $loan->member->name ?? '-',
                'borrow_date' => $loan->borrow_date,
                'due_date' => $loan->due_date,
                'loan_status' => $loan->loan_status,
            ];
        });

        return view('loans.index')->with([
            'loans' => $loans,
            'notFound' => $notFound,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = Member::all();
        $books = Book::all();
        return view('loans.create', compact('members', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
        'member_id' => 'required',
        'book_id' => 'required',
        'borrow_date' => 'required|date',
        'due_date' => 'required|date'
        ]);
        
        $book = Book::find($validated['book_id']);
        if (!$book || !$book->availability) {
        return redirect()->back()
            ->with('error', 'Book not available for loan')
            ->withInput();
    }
        $validated['loan_status'] = 'borrowed';

        $loan = Loan::create($validated);

        $book->availability = false;
        $book->save();

        $member = Member::find($validated['member_id']);
        if ($member) {
            $member->borrowing = true;
            $member->save();
        }

        return redirect()->route('loans.index')->with('success', 'Loan successfully added');
}

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        return view('loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        //
    }
    public function markAsReturned(Loan $loan)
{
    if (in_array($loan->loan_status, ['borrowed', 'overdue'])) {
        $loan->update([
            'loan_status' => 'returned',
            'return_date' => Carbon::now(),
        ]);
    }

    return redirect()->back()->with('success', 'Loan marked as returned.');
}
}
