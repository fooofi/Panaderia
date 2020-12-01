<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'quantity',
        'decrease',
        'quantity_in_quintals',
        'efective_decrease',
        'cost',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->using(OrderProduction::class);
    }
}
