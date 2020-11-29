<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactStatus extends Model
{
    use HasFactory;


    protected $fillable = [
        'status'
    ];

    public function video_calls()
    {
        return $this->hasMany(VideoCall::class);
    }
}
