<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduction extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'production_id',
        'quantity'
    ];
    
}
