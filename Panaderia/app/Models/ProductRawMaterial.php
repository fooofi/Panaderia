<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductRawMaterial extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'raw_material_id',
        'product_id'
    ];


}
