<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
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

    public function date_create()
    {
        return $this->created_at->format('d/m/Y');
    }

    // TODO: Se debe descontar this quantity de los orders que existan y cantidades
    public function stock()
    {
        $orderProductions = OrderProduction::where('production_id', $this->id )
                    ->get();

        $originalStock = $this->quantity;

        foreach ($orderProductions as $orderProduction) 
        {
            $originalStock -= $orderProduction->quantity;    
        }

        return $originalStock;
    }
}
