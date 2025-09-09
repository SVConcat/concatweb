<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    protected $searchable = [
        'title',
        'description',
    ];

    public function getSearchable()
    {
        return $this->searchable;
    }

    public function getBannerUrlAttribute()
    {
        if ($this->image === null) {
            return asset('assets/images/logo-black.svg');
        }

        return Storage::url($this->image);
    }

    public function getBannerAttribute()
    {
        return $this->image !== null;
    }

    public function getFormattedDate($date)
    {
        if ($date === null) {
            return null;
        }
        return $date->format('H:i d-m-Y');
    }
}
