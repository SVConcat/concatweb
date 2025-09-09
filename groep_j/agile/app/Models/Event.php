<?php

namespace App\Models;

use App\Enums\ActiveTypeEnum;
use App\Enums\EventCategoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'price',
        'capacity',
        'banner',
        'category',
        'payment_link',
        'is_open',
        'gallery',
        'status',
        'start_date',
        'end_date',
        'location',
        'google_calendar_event_id',
        'weeztix_event_id',
    ];

    protected $searchable = [
        'title',
        'start_date',
        'location',
        'status',
        'category',
    ];

    protected $casts = [
        'category' => EventCategoryEnum::class,
        'start_date' => 'datetime',
        'status' => ActiveTypeEnum::class,
        'gallery' => 'array',
        'end_date' => 'datetime',
        'is_open' => 'boolean',
    ];

    public function sponsors(): BelongsToMany
    {
        return $this->belongsToMany(Sponsor::class, 'event_sponsors', 'event_id', 'sponsor_id');
    }

    public function registeredUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_registries', 'event_id', 'user_id');
    }

    public function getBannerUrlAttribute()
    {
        if ($this->banner === null) {
            return 'assets/images/logo-black.svg';
        }
        return Storage::url($this->banner);
    }

    public function getRegistryCountAttribute()
    {
        return $this->registeredUsers()->count() > 0 ? $this->registeredUsers()->count() : '-';
    }

    public function getRegistryPercentageAttribute()
    {
        if ($this->capacity > 0) {
            return round(($this->registeredUsers()->count() / $this->capacity) * 100, 2);
        }
        return null;
    }

    public function getGalleryImagePath($image)
    {
        $imagePath = is_array($image) ? ($image['path'] ?? null) : $image;
        return Storage::url($imagePath);
    }

    public function hasPhotos()
    {
        return !empty($this->gallery);
    }

    public function getFormattedDate($date)
    {
        if ($date === null) {
            return null;
        }
        return $date->format('H:i d-m-Y');
    }

    public function getFormattedDateForInput($date)
    {
        if ($date === null) {
            return null;
        }
        return $date->format('Y-m-d H:i');
    }

    public function getSearchable()
    {
        return $this->searchable;
    }

    public function isRegistered()
    {
        return $this->registeredUsers->contains(Auth::user()->id);
    }
}
