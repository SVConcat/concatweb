<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

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

    public function getFormattedStartDatumAttribute(): ?string
    {
        return Carbon::parse($this->datum)->format('d-m-Y');
    }

    public function getFormattedEindDatumAttribute(): ?string
    {
        return Carbon::parse($this->einddatum)->format('d-m-Y');
    }

    public function getFormattedStartTijdAttribute(): ?string
    {
        return Carbon::parse($this->starttijd)->format('H:i');
    }

    public function getFormattedEindTijdAttribute(): ?string
    {
        return Carbon::parse($this->eindtijd)->format('H:i');
    }

    public function getRegisteredCountAttribute(): int
    {
        return $this->registrations()->count();
    }

    public function getAvailableSpotsAttribute(): int
    {
        return $this->aantal_beschikbare_plekken ?? 0;
    }

    public function getShortDescriptionAttribute(): string
    {
        return Str::limit(strip_tags($this->beschrijving), 150, '...');
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

    public static function latestEvent(): ?self
    {
        return self::orderBy('created_at', 'desc')->first();
    }
}
