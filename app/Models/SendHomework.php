<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendHomework extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'homework_id',
        'student_id',
        'document',
    ];
    
}
