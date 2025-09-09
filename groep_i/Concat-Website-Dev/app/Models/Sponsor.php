<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Sponsor extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function formattedDescription(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => Str::markdown(
                str_replace("\n\n", "\n<br />\n", $attributes['description'] ?? ''),
                [
                    'html_input' => 'strip',
                    'allow_unsafe_links' => false,
                    'renderer' => [
                        'soft_break' => "<br />\n",
                    ],
                ]
            )
        );
    }
}
