<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stock',
        'type_measure_id',
        'cost'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->using(ProductRawMaterial::class);
    }

    public function measure()
    {
        return $this->belongsTo(TypeMeasure::class);
    }
}
