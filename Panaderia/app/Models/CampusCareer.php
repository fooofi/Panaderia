<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CampusCareer extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'campus_id',
        'career_id'
    ];

}
