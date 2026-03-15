<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasFileUpload
{
    public function replaceFile(UploadedFile $file, string $directory, string $disk, string $column): string
    {
        if (!empty($this->{$column})) {
            Storage::disk($disk)->delete($this->{$column});
        }

        $path = $file->store($directory, $disk);
        $this->{$column} = $path;

        return $path;
    }

    public function removeFile(string $disk, string $column): bool
    {
        $deletable = !empty($this->{$column});
        if ($deletable) {
            Storage::disk($disk)->delete($this->{$column});
        }
        return $deletable;
    }
}
