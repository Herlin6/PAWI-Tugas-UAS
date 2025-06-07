<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MemberPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Member $member): bool
    {
        return in_array($user->role, ['admin', 'member']);
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Member $member): bool
    {
        return $user->role === 'admin';
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
