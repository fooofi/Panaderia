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
        'detail',
        'total_to_pay',
        'decrease'
    ];

    public function productions()
    {
        return $this->belongsToMany(Production::class)->using(OrderProduction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    public function date_create()
    {
        return $this->created_at->format('d/m/Y');
    }
    
}
