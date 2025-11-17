<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreviousBoard extends Model
{
    protected $fillable = [
        'FromYear',
        'ToYear',
        'members',
        'photo'
    ];

    public $timestamps = true;

    public function getFormattedFromYearAttribute(): string
    {
        return $this->FromYear->format('Y-m-d');
    }

    public function getFormattedToYearAttribute(): string
    {
        return $this->ToYear->format('Y-m-d');
    }
}
