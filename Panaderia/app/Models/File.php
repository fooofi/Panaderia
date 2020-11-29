<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'fileable_id', 'fileable_type'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->disk = config('filesystems.default');
        });
    }
    public function fileable()
    {
        return $this->morphTo();
    }
}
