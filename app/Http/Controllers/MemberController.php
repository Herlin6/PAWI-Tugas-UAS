<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $members = collect();
        $notFound = false;

        if ($search) {
            $members = Member::where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->get();

            if ($members->isEmpty()) {
                $notFound = true;
                $members = [];
            }
        } else {
            $members = Member::all();
        }

        return view('members.index')->with([
            'members' => $members,
            'notFound' => $notFound,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_number' => 'required|max:15|unique:members,member_number',
            'name' => 'required|max:100',
            'email' => 'required|max:100|email|unique:members,email',
            'date_of_birth' => 'required|date',
            'gender' => 'required',
            'address' => 'required|max:255',
            'handphone' => 'required|max:15',
            'employment' => 'required|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('images'), $photoName);
            $validated['photo'] = $photoName;
        }

        Member::create($validated);

        return redirect()->route('members.index')->with('success', 'Members successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }
}
