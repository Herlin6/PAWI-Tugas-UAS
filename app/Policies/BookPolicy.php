<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Book $book): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }
}