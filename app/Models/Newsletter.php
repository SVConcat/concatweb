<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $fillable = [
        'titel',
        'publicatiedatum',
        'inhoud',
        'pdf',
        'images',
    ];

    public $timestamps = true;

    protected $casts = [
        'inhoud' => 'array',
        'images' => 'array',
        'publicatiedatum' => 'date',
    ];
}
