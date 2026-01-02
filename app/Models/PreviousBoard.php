<?php

namespace App\Models;

use App\Traits\HasFileUpload;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PreviousBoard extends Model
{
    use HasFileUpload;

    protected $fillable = [
        'FromYear',
        'ToYear',
        'members',
        'photo'
    ];

    public $timestamps = true;

    public function getFormattedFromYearAttribute(): string
    {
        return Carbon::parse($this->FromYear)->format('Y-m-d');
    }

    public function getFormattedToYearAttribute(): string
    {
        return Carbon::parse($this->ToYear)->format('Y-m-d');
    }

    public function getOnlyFromYearAttribute(): string
    {
        return Carbon::parse($this->FromYear)->format('Y');
    }

    public function getOnlyToYearAttribute(): string
    {
        return Carbon::parse($this->ToYear)->format('Y');
    }
}
