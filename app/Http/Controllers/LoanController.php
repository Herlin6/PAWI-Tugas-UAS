<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $loans = Loan::with(['book', 'member.user'])->get();

        $tableData = $loans->map(function($loan) {
            return [
                'id' => $loan->id,
                'book_title' => $loan->book->title ?? '-',
                'member_name' => $loan->member->user->name ?? '-',
                'borrow_date' => $loan->borrow_date ? \Carbon\Carbon::parse($loan->borrow_date)->format('Y-m-d') : '-',
                'due_date' => $loan->due_date ? \Carbon\Carbon::parse($loan->due_date)->format('Y-m-d') : '-',
                'loan_status' => $loan->loan_status,
                'returning' => $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('Y-m-d') : 'Not yet returned',
                'action' => '',
            ];
        })->values()->all();

        return view('loans.index', [
            'tableData' => $tableData
        ]);
    }


    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Loan::class)) {
            return response()->view('errors.403', [], 403);
        }
        $members = Member::with('user')->get();
        $books = Book::all();
        return view('loans.create', compact('members', 'books'));
    }

    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Loan::class)) {
            return response()->view('errors.403', [], 403);
        }

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
            'loan_status' => 'borrowed',
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

    public function show(Request $request, Loan $loan)
    {
        if ($request->user()->cannot('view', $loan)) {
            return response()->view('errors.403', [], 403);
        }
        return view('loans.show', compact('loan'));
    }

    public function edit(Request $request, Loan $loan)
    {
        if ($request->user()->cannot('update', $loan)) {
            return response()->view('errors.403', [], 403);
        }
        $members = Member::with('user')->get();
        $books = Book::pluck('title', 'id')->toArray();
        $book = $loan->book;
        return view('loans.edit', compact('loan', 'members', 'books', 'book'));
    }

    public function update(Request $request, Loan $loan)
    {
        if ($request->user()->cannot('update', $loan)) {
            return response()->view('errors.403', [], 403);
        }

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

        // Validasi apakah member yang dipilih berbeda
        if ($loan->member_id != $validated['member_id']) {
            if ($oldMember) {
                $oldMember->borrowing = false;
                $oldMember->save();
            }
            if ($newMember) {
                $newMember->borrowing = true;
                $newMember->save();
            }
        }

        // Validasi apakah book yang dipilih berbeda
        if ($loan->book_id != $validated['book_id']) {
            if ($oldBook) {
                $oldBook->availability = true;
                $oldBook->save();
            }
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
        } elseif (in_array($validated['loan_status'], ['borrowed', 'overdue'])) {
            if ($newBook) {
                $newBook->availability = false;
                $newBook->save();
            }
            if ($newMember) {
                $newMember->borrowing = true;
                $newMember->save();
            }
        }

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

    public function destroy(Request $request, Loan $loan)
    {
        if ($request->user()->cannot('delete', $loan)) {
            return response()->view('errors.403', [], 403);
        }

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

    public function markAsReturned(Request $request, Loan $loan)
    {
        if ($request->user()->cannot('markAsReturned', $loan)) {
            return response()->view('errors.403', [], 403);
        }

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

    public function userIndex(Request $request)
    {
        if ($request->user()->cannot('viewAny', Loan::class)) {
            return response()->view('errors.403', [], 403);
        }

        $user = Auth::user();

        // Cari ID member yang sesuai dengan user login
        $memberId = Member::where('user_id', $user->id)->value('id');

        if (!$memberId) {
            return back()->with('error', 'Data member tidak ditemukan.');
        }

        $loans = Loan::with('book')
            ->where('member_id', $memberId)
            ->orderByDesc('created_at')
            ->get();

        return view('loans.user', compact('loans'));
    }




}
