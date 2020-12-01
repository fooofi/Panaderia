<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function raw_materials()
    {
        return $this->belongsToMany(RawMaterial::class)->using(ProductRawMaterial::class);
    }

    public function measure()
    {
        return $this->belongsTo(TypeMeasure::class);
    }

    public function type()
    {
        return $this->belongsTo(TypeProduct::class);
    }
}
