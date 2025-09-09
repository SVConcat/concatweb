<?php
namespace App\Services;

use App\Models\Statue;
use Illuminate\Support\Facades\Storage;

class StatueService{
    public function storeStatue($request)
    {
        $validated = $request->validated();
        $validated['filepath'] = FileService::StoreFile($request, 'filepath');
        Statue::create($validated);
    }

    public function updateStatue($request)
    {
        $validated = $request->validated();
        if($request->hasFile('filepath')){
            $statue = Statue::Query()->first();
            Storage::disk('public')->delete($statue->filepath);
            $validated['filepath'] = FileService::StoreFile($request, 'filepath');
            $statue->update($validated);
        }
    }
}
