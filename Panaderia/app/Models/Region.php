<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function provinces()
    {
        return $this->hasMany(Province::class);
    }

    public function collapseName()
    {
        return $this->name . ', ' . $this->country->collapseName();
    }
    public function geocodeComponent()
    {
        return 'administrative_area_level_1:' . preg_replace('/\s+/', '+', $this->name);
    }
}
