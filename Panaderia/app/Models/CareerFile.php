<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerFile extends Model
{
    use HasFactory;
    protected $fillable = ['career_id'];

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
