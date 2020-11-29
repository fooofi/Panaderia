<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FairSurvey extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fair_user_id',
        'school_id',
        'grade_id',
        'university',
        'ip',
        'cft',
        'ffaa',
        'gratuidad',
        'cae',
        'propio',
        'becas',
        'career',
        'institution',
    ];

    public function fair_user()
    {
        return $this->belongsTo(FairUser::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
