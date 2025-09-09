<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessImageUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, \Illuminate\Bus\Queueable, SerializesModels;

    protected $filePath;
    protected $originalName;
    protected $path;

    public function __construct($filePath, $originalName, $path)
    {
        $this->filePath = $filePath;
        $this->originalName = $originalName;
        $this->path = $path;
    }

    public function handle()
    {
        $destinationPath = $this->path . '/' . $this->originalName;
        if (!Storage::disk('public')->exists($destinationPath)) {
            Storage::disk('public')->move($this->filePath, $destinationPath);
        }
    }
}
