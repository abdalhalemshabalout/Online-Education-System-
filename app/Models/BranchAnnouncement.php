<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_id',
        'branch_id',
        'head',
        'body',
        'isActive',
    ];
}
