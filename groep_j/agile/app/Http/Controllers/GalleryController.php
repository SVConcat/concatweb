<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Services\ImageService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    public function index(Request $request)
    {
        $galleries = Gallery::where('page_key', 'gallery')->first();
        if($request->route()->named('admin.gallery.index'))
        {
            return view('admin.galleries.index', ['gallery' => $galleries]);
        }
        return view('user.galleries.index', ['gallery' => $galleries]);
    }



    public function storeGallery(Request $request, $model)
    {
        $model = $this->getModel($model, $request->id);
        return ImageService::storeOrUpdateGallery($request, $model, 'gallery');
    }

    public function uploadGallery(Request $request, $model, $id)
    {
        $model = $this->getModel($model, $id);
        return ImageService::storeOrUpdateGallery($request, $model, $request->attribute);
    }

    public function fetchGallery($model, $id)
    {
        $model = $this->getModel($model, $id);
        return ImageService::fetchDropzoneImages($model, 'gallery');
    }

    public function deleteGallery(Request $request, $model, $id)
    {
        $model = $this->getModel($model, $id);
        return ImageService::deleteDropzoneImages($model, $request, $request->attribute);
    }

    public function updateMetadata(Request $request, $model, $id)
    {
        $model = $this->getModel($model, $id);
        return ImageService::processGalleryMetadata($request, $model);
    }

    public function getModel($model, $id)
    {
        $modelClass = 'App\\Models\\' . ucfirst($model);

        if (!class_exists($modelClass)) {
            abort(404, 'Model not found');
        }

        return $modelClass::findOrFail($id);
    }
}
