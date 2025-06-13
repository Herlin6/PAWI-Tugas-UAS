<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LoanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'member';
    }

    public function view(User $user, Loan $loan): bool
    {
        return $user->role === 'admin' || $loan->member->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Loan $loan): bool
    {
        return $user->role === 'admin' || $loan->user_id === $user->id;
    }

    public function delete(User $user, Loan $loan): bool
    {
        return $user->role === 'admin' || $loan->user_id === $user->id;
    }

    public function restore(User $user, Loan $loan): bool
    {
        return false;
    }

    public function forceDelete(User $user, Loan $loan): bool
    {
        return false;
    }
    
    public function markAsReturned(User $user, Loan $loan): bool
    {
        return $user->role === 'admin';
    }
}
