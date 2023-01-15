<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrangeQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'question_type',
        'exam_id',
        'question_number',
        'question_type',
        'question',
        'image',
        'answer_point'
    ];
}
