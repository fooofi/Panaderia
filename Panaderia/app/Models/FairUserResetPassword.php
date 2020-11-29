<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FairUserResetPassword extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fair_user_id',
        'token',
        'ip',
        'browser',
        'so'
    ];


    public function fair_user()
    {
        return $this->belongsTo(FairUser::class);
    }
}
