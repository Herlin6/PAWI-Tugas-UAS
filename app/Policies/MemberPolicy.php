<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MemberPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'member';
    }

    public function view(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Member $member): bool
    {
        return $user->role === 'admin' || $user->id === $member->user_id;
    }

    public function delete(User $user, Member $member): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Member $member): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Member $member): bool
    {
        return $user->role === 'admin';
    }
}
