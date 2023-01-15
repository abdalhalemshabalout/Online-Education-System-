<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'role_id',
        'student_id',
        'name',
        'surname',
        'parent',
        'telephone',
        'email',
        'password',
        'image',
        'isActive',
        'isDeleted'
    ];
}
