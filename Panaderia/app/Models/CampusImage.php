<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampusImage extends Model
{
    use HasFactory;

    protected $fillable = ['campus_id'];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
