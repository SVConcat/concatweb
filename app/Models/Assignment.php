<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'company_name',
        'email',
        'phone_number',
    ];

    public $timestamps = true;
}
