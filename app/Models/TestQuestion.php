<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'question_type',
        'exam_id',
        'question_number',
        'question',
        'image',
        'answer_one',
        'answer_two',
        'answer_three',
        'answer_four',
        'answer_five',
        'correct_answer',
        'answer_point'
    ];
}
