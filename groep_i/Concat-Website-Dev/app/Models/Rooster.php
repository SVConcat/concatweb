<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rooster extends Model
{
    // Add this property to allow mass assignment of ical_url
    protected $fillable = [
        'ical_url', 'klas',
    ];
}
