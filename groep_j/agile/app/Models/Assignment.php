<?php

namespace App\Models;

use App\Enums\ActiveTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'title',
        'company',
        'description',
        'reward',
        'url',
        'contact_email',
        'contact_phone',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $searchable = [
        'title',
        'company',
        'contact_email',
    ];

    public function getSearchable()
    {
        return $this->searchable;
    }
}
