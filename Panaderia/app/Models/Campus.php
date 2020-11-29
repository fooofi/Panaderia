<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'link',
        'description',
        'phone',
        'location_lat',
        'location_lon',
        'commune_id',
        'institution_id',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function careers()
    {
        return $this->belongsToMany(Career::class)->using(CampusCareer::class);
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'source_model');
    }

    public function campus_images()
    {
        return $this->hasMany(CampusImage::class);
    }

    public function collapseAddress(bool $province)
    {
        return $this->address . ', ' . $this->commune->collapseName($province);
    }

    public function getOrganizationAttribute()
    {
        return $this->institution->organization;
    }
}
