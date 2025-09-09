<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gallery::where("id", 1)->update([
           "page_key" => "home"
        ]);
        Gallery::firstOrCreate([
            "page_key" => "gallery"
        ]);
    }
}
