<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'region_id'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function communes()
    {
        return $this->hasMany(Commune::class);
    }

    public function collapseName($province = true)
    {
        if ($province) {
            return $this->name . ', ' . $this->region->collapseName();
        } else {
            return $this->region->collapseName();
        }
    }
    public function geocodeComponent()
    {
        return 'administrative_area_level_2:' . preg_replace('/\s+/', '+', $this->name);
    }
}
