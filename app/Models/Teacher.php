<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'role_id',
        'name',
        'surname',
        'telephone',
        'email',
        'password',
        'image',
        'identity_number',
        'country_id',
        'mother_name',
        'father_name',
        'gender',
        'place_of_birth',
        'birth_date',
        'address',
        'management_start_date',
        'department_graduated',
        'isActive',
        'isDeleted',
        'created_at',
    ];
}
