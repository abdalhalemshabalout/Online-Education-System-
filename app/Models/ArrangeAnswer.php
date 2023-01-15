<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrangeAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'student_id',
        'question_id',
        'answer_text',
    ];
}