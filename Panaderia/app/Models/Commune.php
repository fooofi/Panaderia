<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['name', 'code', 'province_id'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function campuses()
    {
        return $this->hasMany(Campus::class);
    }

    public function fair_users()
    {
        return $this->hasMany(FairUser::class);
    }

    public function toSearchableArray()
    {
        return ['name' => $this->toArray()['name']];
    }

    public function collapseName($provinces = true)
    {
        return $this->name . ', ' . $this->province->collapseName($provinces);
    }

    public function geocodeComponent()
    {
        return 'administrative_area_level_3:' . preg_replace('/\s+/', '+', $this->name);
    }
}
