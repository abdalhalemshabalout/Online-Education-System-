<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'lesson_content_id',
        'exam_name',
        'question_number',
        'exam_time',
        'success_grade',
        'start_date',
        'end_date',
        'deleted_at',
        'isActive',
        'isDeleted'
    ];
}
