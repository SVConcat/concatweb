<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Statue extends Model
{
    protected $fillable = [
        'filepath'
    ];

    public function getFilepathUrlAttribute()
    {
        if ($this->filepath === null) {
            return "";
        }
        return Storage::url($this->filepath);
    }
}
