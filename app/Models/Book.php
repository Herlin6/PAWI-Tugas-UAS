<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'book_number',
        'title',
        'author',
        'publisher',
        'isbn',
        'genre',
        'publish_date',
        'synopsis',
        'availability',
        'photo'
    ];

    protected $casts = [
        'publish_date' => 'date',
        'availability' => 'boolean'
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
