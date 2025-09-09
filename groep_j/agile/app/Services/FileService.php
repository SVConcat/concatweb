<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public static function StoreFile($request, $file, $path = "")
    {
        if ($request->hasFile($file)) {
            $file = $request->file($file);
            $currentDate = Carbon::now()->format('d-m-Y');
            $filePath = 'files/' . 'Statuten Concat ' . $currentDate . '.' . $file->getClientOriginalExtension();
            if (!Storage::disk('public')->exists($filePath)) {
                $filePath = $file->storeAs('files'.$path, 'Statuten Concat ' . $currentDate . '.' . $file->getClientOriginalExtension(), 'public');
            }
            return $filePath;
        }
        return null;
    }
}
