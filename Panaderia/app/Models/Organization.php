<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['business_name', 'fantasy_name', 'rut', 'address', 'commune_id', 'organization_type_id'];

    public function organization_type()
    {
        return $this->belongsTo(OrganizationType::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }
}
