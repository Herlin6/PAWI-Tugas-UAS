<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $notFound = false;

        $query = Member::with('user');

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $members = $query->paginate(20);

        if ($search && $members->isEmpty()) {
            $notFound = true;
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
            'remove_photo' => 'nullable|in:0,1',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $member->user_id,
        ]);

        $removePhoto = $request->input('remove_photo') == '1';

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
        } elseif (!$removePhoto) {
            $validated['photo'] = $member->photo;
        }

        if ($request->input('remove_photo') == '1') {
            if ($member->photo && file_exists(public_path($member->photo))) {
                unlink(public_path($member->photo));
            }
            $validated['photo'] = null;
        }

        $memberFields = collect($validated)->except(['name', 'email'])->toArray();
        $member->update($memberFields);

        $user = $member->user;
        if ($user) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();
        }

        if (Auth::user()->role === 'admin') {
            return redirect()->route('members.index')->with('success', 'Member successfully updated');
        } else {
            return redirect()->route('members.profile')->with('success', 'Profile successfully updated');
        }

    }

    public function destroy(Request $request, Member $member)
    {
        if ($request->user()->cannot('delete', $member)) {
            return response()->view('errors.403', [], 403);
        }

        try {
            if ($member->photo && file_exists(public_path($member->photo))) {
                unlink(public_path($member->photo));
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
        if (Auth::user()->role !== 'member') {
            abort(403, 'Unauthorized');
        }
        $member = Auth::user()->member;
        return view('members.user', compact('member'));
    }

}
