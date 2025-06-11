<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'member_number',
        'name',
        'email',
        'date_of_birth',
        'gender',
        'address',
        'handphone',
        'employment',
        'borrowing',
        'photo'
    ];

    protected $casts = [
        'date_of_birth' => 'date'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    public function loans()
    {
        return $this->hasMany(\App\Models\Loan::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
