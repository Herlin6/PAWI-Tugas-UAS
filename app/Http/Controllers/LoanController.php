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
        $members = \App\Models\Member::pluck('name', 'id')->toArray();
        $books = \App\Models\Book::pluck('title', 'id')->toArray();
        $book = $loan->book;
        return view('loans.edit', compact('loan', 'members', 'books', 'book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
            'loan_status' => 'required|in:borrowed,returned,overdue',
        ]);

        // Cek apakah member dan book yang dipilih berbeda dari yang ada di loan
        $oldMember = $loan->member;
        $oldBook = $loan->book;
        $newMember = Member::find($validated['member_id']);
        $newBook = Book::find($validated['book_id']);

        // Validasi apakah book dan member yang dipilih tersedia
        if ($loan->member_id != $validated['member_id']) {
            // Set member lama tidak borrowing
            if ($oldMember) {
                $oldMember->borrowing = false;
                $oldMember->save();
            }
            // Set member baru borrowing
            if ($newMember) {
                $newMember->borrowing = true;
                $newMember->save();
            }
        }

        // Validasi apakah book yang dipilih tersedia
        if ($loan->book_id != $validated['book_id']) {
            // Set book lama available
            if ($oldBook) {
                $oldBook->availability = true;
                $oldBook->save();
            }
            // Set book baru not available
            if ($newBook) {
                $newBook->availability = false;
                $newBook->save();
            }
        }

        // Update status availability dan borrowing berdasarkan loan_status
        if ($validated['loan_status'] === 'returned') {
            if ($newBook) {
                $newBook->availability = true;
                $newBook->save();
            }
            if ($newMember) {
                $newMember->borrowing = false;
                $newMember->save();
            }
        } elseif ($validated['loan_status'] === 'borrowed' || $validated['loan_status'] === 'overdue') {
            if ($newBook) {
                $newBook->availability = false;
                $newBook->save();
            }
            if ($newMember) {
                $newMember->borrowing = true;
                $newMember->save();
            }
        }

        // Update data loan
        $loan->update([
            'member_id' => $validated['member_id'],
            'book_id' => $validated['book_id'],
            'borrow_date' => $validated['borrow_date'],
            'due_date' => $validated['due_date'],
            'return_date' => $validated['return_date'] ?? null,
            'loan_status' => $validated['loan_status'],
        ]);

        return redirect()->route('loans.index')->with('success', 'Loan successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        // Kembalikan status buku menjadi available jika loan sedang borrowed/overdue
        if ($loan->book && in_array($loan->loan_status, ['borrowed', 'overdue'])) {
            $loan->book->availability = true;
            $loan->book->save();
        }

        // Kembalikan status member menjadi tidak borrowing jika loan sedang borrowed/overdue
        if ($loan->member && in_array($loan->loan_status, ['borrowed', 'overdue'])) {
            $loan->member->borrowing = false;
            $loan->member->save();
        }

        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Loan successfully deleted');
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
