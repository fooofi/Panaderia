<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'educational_level_id'
    ];

    public function careers()
    {
        return $this->hasMany(Career::class);
    }

    public function educationalLevel()
    {
        return $this->belongsTo(EducationalLevel::class);
    }
    
}

