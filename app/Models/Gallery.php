<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'type',
        'src',
    ];

    public $timestamps = true;

    public function getImageUrlAttribute()
    {
        if (str_starts_with($this->src, 'http')) {
            return $this->src;
        }

        return Storage::url($this->src);
    }

    public function evenementen(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'evenementen_gallery', 'gallery_id', 'event_id');
    }
}
