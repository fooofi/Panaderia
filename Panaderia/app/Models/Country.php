<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function collapseName()
    {
        return $this->name;
    }

    public function geocodeComponent()
    {
        return 'country:' . preg_replace('/\s+/', '+', $this->name);
    }
}
