<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrerScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'career_id',
        'year',
        'nem',
        'ranking',
        'math',
        'history_science',
        'max_score',
        'avg_score',
        'min_score',
        'language'
    ];

    public function careers()
    {
        return $this->hasMany(Career::class);
    }

}
