<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    // Corrigeer naar de juiste velden
    protected $fillable = [
        'titel',
        'inhoud',
        'published_at',
        'isVisible'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'isVisible' => 'boolean'
    ];
}
