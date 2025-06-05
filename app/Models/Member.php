<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'member_number',
        'name',
        'email',
        'date_of_birth',
        'gender',
        'address',
        'handphone',
        'employment',
        'photo',
        'borrowing'
    ];

    protected $casts = [
        'date_of_birth' => 'date'
    ];

    public function review()
    {
        return $this->hasMany(Review::class, 'review_id', 'id');
    }

    public function loan()
    {
        return $this->hasMany(Loan::class, 'loan_id', 'id');
    }
}
