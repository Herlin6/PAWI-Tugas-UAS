<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function review()
    {
        return $this->hasMany(Review::class, 'review_id', 'id');
    }

    public function loan()
    {
        return $this->hasMany(Loan::class, 'loan_id', 'id');
    }
}
