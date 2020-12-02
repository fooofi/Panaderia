<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type_product_id',
        'type_measure_id',
    ];

    public function raw_materials()
    {
        return $this->belongsToMany(RawMaterial::class)->using(ProductRawMaterial::class);
    }

    public function type_measure()
    {
        return $this->belongsTo(TypeMeasure::class);
    }

    public function type_product()
    {
        return $this->belongsTo(TypeProduct::class);
    }

    // TODO: mejorar formula
    public function get_cost()
    {
        $sum = 0;

        foreach ($this->raw_materials as $raw_material)
        {
            $sum += $raw_material->cost;
        }

        return $sum;
    }
}
