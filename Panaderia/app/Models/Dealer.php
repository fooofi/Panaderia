<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lasname',
        'phone',
        'email',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}