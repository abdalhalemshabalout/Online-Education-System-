<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'classroom_id',
        'branch_id',
        'program',
    ];
}
