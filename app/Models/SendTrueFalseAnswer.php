<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendTrueFalseAnswer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'student_id',
        'exam_id',
        'question_id',
        'answer',
    ];
}
