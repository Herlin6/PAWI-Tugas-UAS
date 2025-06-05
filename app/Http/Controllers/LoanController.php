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
                'borrow_date' => $loan->borrow_date ? Carbon::parse($loan->borrow_date)->toDateString() : '-',
                'due_date' => $loan->due_date ? Carbon::parse($loan->due_date)->toDateString() : '-',
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
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'length_of_loan' => 'required|integer|min:1',
        ]);

        // Cek status buku dan member
        $book = Book::find($validated['book_id']);
        $member = Member::find($validated['member_id']);

        if (($book && !$book->availability) || ($member && $member->borrowing)) {
            return redirect()->back()->withInput()->with('error', 'Book is not available or the member is currently borrowing another book.');
        }

        // Hitung due_date
        $due_date = Carbon::parse($validated['borrow_date'])->addDays((int) $validated['length_of_loan']);

        // Simpan ke database (hanya tanggal, tanpa waktu)
        Loan::create([
            'member_id' => $validated['member_id'],
            'book_id' => $validated['book_id'],
            'borrow_date' => Carbon::parse($validated['borrow_date'])->toDateString(),
            'due_date' => $due_date->toDateString(),
        ]);

        // Set book availability menjadi false (not available)
        if ($book) {
            $book->availability = false;
            $book->save();
        }

        // Set member borrowing menjadi true (borrowing)
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

    /**
     * Mark loan as returned.
     */
    public function markAsReturned(Loan $loan)
    {
        if (in_array($loan->loan_status, ['borrowed', 'overdue'])) {
            $loan->update([
                'loan_status' => 'returned',
                'return_date' => Carbon::now()->toDateString(),
            ]);

            // Set book available
            if ($loan->book) {
                $loan->book->availability = true;
                $loan->book->save();
            }

            // Set member not borrowing
            if ($loan->member) {
                $loan->member->borrowing = false;
                $loan->member->save();
            }
        }

        return redirect()->back()->with('success', 'Loan marked as returned.');
    }
}
