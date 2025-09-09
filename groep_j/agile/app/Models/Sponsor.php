<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Sponsor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
        'active',
        'url'
    ];

    /**
     * Get the events for the sponsor.
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_sponsors', 'sponsor_id', 'event_id');
    }

    public function getImageUrlAttribute(): string
    {
        return Storage::url($this->image);
    }
}
