<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'type',
        'src',
    ];

    public function evenementen()
    {
        return $this->belongsToMany(Events::class, 'evenementen_gallery', 'gallery_id', 'event_id');
    }
}
