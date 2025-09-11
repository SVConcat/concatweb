<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CommunityNight extends Model
{
    protected $guarded = [];

    use HasFactory;

    // TODO: Fix this function
//    public function image(): Attribute
//    {
//        return Attribute::make(
//            get: fn() => Storage::disk('community-nights')->url($this->attributes['image']),
//        );
//    }

    public function startTime(): Attribute
    {
        return Attribute::make(
            get: static fn($value) => Carbon::parse($value)->format('H:i'),
        );
    }

    public function endTime(): Attribute
    {
        return Attribute::make(
            get: static fn($value) => Carbon::parse($value)->format('H:i'),
        );
    }

    public function date(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->attributes['start_time'])->format('d-m-Y'),
        );
    }

    public function formattedDescription(): Attribute
    {
        return Attribute::make(
            get: fn() => nl2br(e($this->attributes['description'] ?? '')),
        );
    }

    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->attributes['updated_at'])->format('d-m-Y'),
        );
    }

    public function formattedCapacity(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->attributes['capacity'] === null ? 'Onbeperkt' : (string)$this->attributes['capacity'],
        );
    }

    public function fullStartTime(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->attributes['start_time']),
        );
    }
}
