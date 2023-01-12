<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'lesson_id',
        'head',
        'body',
        'deleted_at',
        'isActive'
    ];
}
