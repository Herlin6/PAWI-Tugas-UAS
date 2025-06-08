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
        $users = \App\Models\User::whereDoesntHave('member')->where('role', '!=', 'admin')->get();
        return view('members.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'member_number' => 'required|max:15|unique:members,member_number',
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

        $member = Member::create($validated);

        // Ubah role user menjadi "member"
        $user = \App\Models\User::find($request->user_id);
        $user->role = 'member';

        // Jika ingin mengubah nama user dari input form (misal ada input name di form)
        if ($request->filled('name')) {
            $user->name = $request->input('name');
        }
        $user->save();

        return redirect()->route('members.index')->with('success', 'Member successfully added');
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
        $validated = $request->validate([
            'member_number' => 'required|max:15|unique:members,member_number,' . $member->id,
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

        // Update nama user jika ada input name di form
        if ($request->filled('name')) {
            $member->user->name = $request->input('name');
            $member->user->save();
        }

        return redirect()->route('members.index')->with('success', 'Member successfully updated');
    }

    public function destroy(Request $request, Member $member)
    {
        if ($request->user()->cannot('delete', $member)) {
            return response()->view('errors.403', [], 403);
        }

        try {
            if ($member->photo && file_exists(public_path('images/' . $member->photo))) {
                unlink(public_path('images/' . $member->photo));
            }

            if ($member->user) {
                $member->user->role = 'guest';
                $member->user->save();
            }

            $member->delete();

            return redirect()->route('members.index')->with('success', 'Member successfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangkap error foreign key constraint
            return redirect()->route('members.index')
                ->with('error', 'Failed to delete! The member still has active loans.');
        }
    }

    public function userIndex()
    {
        return view('members.user');
    }
}
