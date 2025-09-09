<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Commission extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    protected $searchable = [
        'name',
        'description',
    ];
    public function getSearchable()
    {
        return $this->searchable;
    }
}
