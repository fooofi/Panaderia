<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipOwner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function scholarships()
    {
        return $this->hasMany(Scholarship::class);
    }
}
