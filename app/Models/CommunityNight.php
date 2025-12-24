<?php

namespace App\Models;

use App\Traits\HasFileUpload;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityNight extends Model
{
    use HasFactory, HasFileUpload;

    protected $fillable = [
        'title',
        'image',
        'description',
        'start_time',
        'end_time',
        'location',
        'link',
        'capacity',
    ];

    public $timestamps = true;

    public function getFormattedStartTimeAttribute(): ?string
    {
        return Carbon::parse($this->start_time)->format('Y-m-d\TH:i');
    }

    public function getFormattedEndTimeAttribute(): ?string
    {
        return Carbon::parse($this->end_time)->format('Y-m-d\TH:i');
    }

    public function getFormattedUpdatedAtAttribute(): ?string
    {
        return Carbon::parse($this->updated_at)->format('Y-m-d H:i');
    }


    public function getDiscordStartDateAttribute(): ?string
    {
        return Carbon::parse($this->start_time)->format('d-m-Y');
    }

    public function getDiscordStartTimeAttribute(): ?string
    {
        return Carbon::parse($this->start_time)->format('H:i');
    }

    public function getDiscordEndTimeAttribute(): ?string
    {
        return Carbon::parse($this->end_time)->format('H:i');
    }

    public static function latestCommunityNight(): ?self
    {
        return self::orderBy('created_at', 'desc')->first();
    }
}
