<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'link',
        'phone',
        'cruch',
        'gratuidad',
        'sua',
        'organization_id',
        'institution_type_id',
        'institution_dependency_id',
    ];

    public function institution_type()
    {
        return $this->belongsTo(InstitutionType::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function institution_dependency()
    {
        return $this->belongsTo(InstitutionDependency::class);
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function campuses()
    {
        return $this->hasMany(Campus::class);
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'source_model');
    }

    public function careers()
    {
        return $this->hasMany(Career::class);
    }

    public function institution_banner()
    {
        return $this->hasOne(InstitutionBanner::class);
    }

    public function institution_icon()
    {
        return $this->hasOne(InstitutionIcon::class);
    }
}
