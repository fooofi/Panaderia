<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'rbd',
        'dgv_rbd',
        'type',
        'location',
        'status',
        'tuition_cost',
        'monthly_cost',
        'commune_id',
        'school_dependence_id',
    ];

    public function fair_user_profiles()
    {
        return $this->hasMany(FairUserProfile::class);
    }

    public function school_dependency()
    {
        return $this->belongsTo(SchoolDependency::class);
    }

    public function specialities()
    {
        return $this->belongsToMany(Speciality::class)->using(SchoolSpeciality::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function toSearchableArray()
    {
        return ['name' => $this->toArray()['name']];
    }
}
