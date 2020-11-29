<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'fair_user_id',
        'user_id',
        'organization_id',
        'source_model_id',
        'source_model_type',
        'contact_status_id',
        'contact_type_id',
        'channel',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fair_user()
    {
        return $this->belongsTo(FairUser::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function contact_status()
    {
        return $this->belongsTo(ContactStatus::class);
    }

    public function source_model()
    {
        return $this->morphTo();
    }

    public function contact_type()
    {
        return $this->belongsTo(ContactType::class);
    }

    public function institutionId()
    {
        if ($this->source_model_type == 'App\\Models\\Institution') {
            return $this->source_model_id;
        }
        return $this->source_model->institution_id;
    }
}
