<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $guarded = [];

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'event_id');  // Notice the second parameter for custom foreign key
    }
    public function isUserRegistered($userId)
    {
        return $this->registrations()->where('user_id', $userId)->exists();
    }
    public function gallery()
    {
        return $this->belongsToMany(Gallery::class, 'evenementen_gallery');
    }

    /**
     * Get the number of registered users for the event.
     */
    public function getRegisteredCountAttribute()
    {
        return $this->registrations()->count();
    }

    /**
     * Get the total number of available spots for the event.
     */
    public function getAvailableSpotsAttribute()
    {
        return $this->aantal_beschikbare_plekken ?? 0;
    }
}
