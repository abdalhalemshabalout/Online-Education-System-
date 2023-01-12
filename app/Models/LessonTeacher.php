<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonTeacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'classroom_id',
        'branch_id',
        'teacher_id',
        'lesson_id',
    ];
    
}
