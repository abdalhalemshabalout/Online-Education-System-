<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'classroom_id',
        'branch_id',
        'student_id',
        'lesson_id',
    ];
}
