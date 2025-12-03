<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'titel',
        'publicatiedatum',
        'inhoud',
        'pdf',
        'images',
    ];

    protected $casts = [
        'inhoud' => 'array',
        'images' => 'array',
        'publicatiedatum' => 'date',
    ];
}
