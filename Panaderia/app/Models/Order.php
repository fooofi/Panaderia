<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'user_id',
        'client_id',
        'dealer_id',
    ];

    public function products()
    {
        return $this->belongsToMany(Production::class)->using(OrderProduction::class);
    }
}
