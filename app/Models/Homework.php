<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'lesson_content_id',
        'name',
        'description',
        'document',
        'start_date',
        'end_date',
        'isActive'
    ];
}
