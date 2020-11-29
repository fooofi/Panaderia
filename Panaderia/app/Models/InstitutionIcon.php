<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionIcon extends Model
{
    use HasFactory;

    protected $fillable = ['institution_id'];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
