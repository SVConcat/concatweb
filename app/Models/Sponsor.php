<?php

namespace App\Models;

use App\Traits\HasFileUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use HasFactory, SoftDeletes, HasFileUpload;

    protected $fillable = [
        'name',
        'description',
        'url',
        'image_path',
    ];

    public $timestamps = true;
}
