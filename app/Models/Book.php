<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'book_code',
        'title',
        'subject',
        'author_name',
        'release_date',
        'details'
    ];
}
