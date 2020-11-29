<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Career extends Model
{
    use HasFactory, Searchable;
    protected $fillable = [
        'name',
        'link',
        'career_type_id',
        'area_id',
        'modality_id',
        'semesters',
        'description',
        'video',
        'brochure_pdf',
        'curricular_mesh_pdf',
        'institution_id',
        'accreditation_id',
        'career_regime_id',
    ];

    public function career_type()
    {
        return $this->belongsTo(CareerType::class);
    }

    public function campuses()
    {
        return $this->belongsToMany(Campus::class)->using(CampusCareer::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function accreditation()
    {
        return $this->belongsTo(Accreditation::class);
    }

    public function modality()
    {
        return $this->belongsTo(Modality::class);
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'source_model');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function career_files()
    {
        return $this->hasMany(CareerFile::class);
    }

    public function scholarships()
    {
        return $this->belongsToMany(Scholarship::class)->using(CareerScholarship::class);
    }

    public function career_score()
    {
        return $this->hasOne(CarrerScore::class);
    }

    public function toSearchableArray()
    {
        return ['name' => $this->toArray()['name']];
    }

    public function career_regime()
    {
        return $this->belongsTo(CareerRegime::class);
    }

    public function getOrganizationAttribute()
    {
        return $this->institution->organization;
    }   
    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
