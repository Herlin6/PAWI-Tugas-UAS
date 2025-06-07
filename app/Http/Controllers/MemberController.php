<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
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

    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Member::class)) {
            return response()->view('errors.403', [], 403);
        }
        return view('members.create');
    }

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

    public function show(Request $request, Member $member)
    {
        if ($request->user()->cannot('view', $member)) {
            return response()->view('errors.403', [], 403);
        }
        return view('members.show', compact('member'));
    }

    public function edit(Request $request, Member $member)
    {
        if ($request->user()->cannot('update', $member)) {
            return response()->view('errors.403', [], 403);
        }
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        if ($request->user()->cannot('update', $member)) {
            return response()->view('errors.403', [], 403);
        }

        $validated = $request->validate([
            'member_number' => 'required|max:15|unique:members,member_number,' . $member->id,
            'name' => 'required|max:100',
            'email' => 'required|max:100|email|unique:members,email,' . $member->id,
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:M,F',
            'address' => 'required|max:255',
            'handphone' => 'required|max:15',
            'employment' => 'required|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'remove_photo' => 'nullable|in:1'
        ]);

        $removePhoto = $request->input('remove_photo') == '1';

        // Hapus foto jika user menghapus manual atau mengunggah baru
        if ($removePhoto && $member->photo && file_exists(public_path('images/' . $member->photo))) {
            unlink(public_path('images/' . $member->photo));
            $validated['photo'] = null;
        }

        // Upload foto baru
        if ($request->hasFile('photo')) {
            if ($member->photo && file_exists(public_path('images/' . $member->photo))) {
                unlink(public_path('images/' . $member->photo));
            }
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('images'), $photoName);
            $validated['photo'] = $photoName;
        } elseif (!$removePhoto) {
            // Foto tidak diubah
            $validated['photo'] = $member->photo;
        }

        $member->update($validated);

        return redirect()->route('members.index')->with('success', 'Member successfully updated');
    }

    public function destroy(Request $request, Member $member)
    {
        if ($request->user()->cannot('delete', $member)) {
            return response()->view('errors.403', [], 403);
        }

        if ($member->photo && file_exists(public_path('images/' . $member->photo))) {
            unlink(public_path('images/' . $member->photo));
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member successfully deleted');
    }

    public function userIndex()
    {
        return view('members.user');
    }
}
