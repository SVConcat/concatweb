<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'gallery',
        'page_key',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];

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

        $dateTime = new \DateTime($date);

        return $dateTime->format('d-m-Y');
    }
}
