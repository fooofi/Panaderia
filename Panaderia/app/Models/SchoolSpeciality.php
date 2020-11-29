<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SchoolSpeciality extends Pivot
{
    //
    // protected $table = 'school_specialities';
    protected $fillable = ['school_id', 'speciality_id'];
}
