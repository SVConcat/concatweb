<?php

namespace App\Models;

use App\Traits\HasFileUpload;
use Illuminate\Database\Eloquent\Model;

class BoardMember extends Model
{
    use HasFileUpload;

    protected $fillable = [
        'name',
        'role',
        'bio',
        'photo'
    ];

    public $timestamps = true;
}
