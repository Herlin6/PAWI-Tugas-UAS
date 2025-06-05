<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrow_date',
        'due_date',
        'loan_status',
        'return_date',
        'member_id',
        'book_id',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
