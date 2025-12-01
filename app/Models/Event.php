<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'titel',
        'categorie',
        'datum',
        'einddatum',
        'starttijd',
        'eindtijd',
        'beschrijving',
        'locatie',
        'aantal_beschikbare_plekken',
        'betaal_link',
        'afbeelding'
    ];

    public $timestamps = true;

    public function getRegisteredCountAttribute(): int
    {
        return $this->registrations()->count();
    }

    public function getAvailableSpotsAttribute(): int
    {
        return $this->aantal_beschikbare_plekken ?? 0;
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function gallery(): BelongsToMany
    {
        return $this->belongsToMany(Gallery::class, 'evenementen_gallery');
    }

    public function isUserRegistered($userId): bool
    {
        return $this->registrations()->where('user_id', $userId)->exists();
    }
}
