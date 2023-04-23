<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctorid',
        'dateofappt',
        'timestart',
        'timeend',
        'remarks',
        'status',
        'specializationID',
        'noofpatients',
        'isOne'

    ];
}
