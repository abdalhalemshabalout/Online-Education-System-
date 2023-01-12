<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassicQuestion extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'question_type',
        'exam_id',
        'question_number',
        'question',
        'image',
        'answer_point'
    ];
}
