<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function careers()
    {
        return $this->belongsToMany(Career::class)->using(CareerScholarship::class);
    }

    public function scholarship_owner()
    {
        return $this->belongsTo(ScholarshipOwner::class);
    }
}
