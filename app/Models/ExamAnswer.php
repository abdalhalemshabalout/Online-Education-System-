<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'student_id',
        'exam_id',
        'question_id',
        'answer_id',
        'question_type',
        'question_number'
    ];
}
