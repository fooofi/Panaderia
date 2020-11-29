<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolDependency extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function schools()
    {
        $this->hasMany(School::class);
    }
}
