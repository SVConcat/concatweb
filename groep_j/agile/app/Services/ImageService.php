<?php

namespace App\Services;

use App\Jobs\ProcessImageUpload;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function StoreImage($request, $image, $path = "")
    {
        if ($request->hasFile($image)) {
            $file = $request->file($image);
            $filePath = 'image/' . $file->getClientOriginalName();
            if (!Storage::disk('public')->exists($filePath)) {
                $filePath = $file->storeAs('images'.$path, $file->getClientOriginalName(), 'public');
            }
            return $filePath;
        }
        return null;
    }

    public static function deleteImage($class, $model, $type)
    {
        if ($model->$type) {
            $otherModels = $class::where($type, $model->$type)->where('id', '!=', $model->id)->count();
            if ($otherModels === 0) {
                Storage::disk('public')->delete($model->$type);
            }
        }
    }

    public static function deleteImages($class, $model)
    {
        $gallery = $model->gallery;
        $otherModels = $class::where('id', '!=', $model->id)->get();

        if (is_array($gallery)) {
            foreach ($gallery as $image) {
                $isUsed = false;
                foreach ($otherModels as $otherModel) {
                    $otherGallery = $otherModel->gallery;
                    if (is_array($otherGallery) && in_array($image, $otherGallery)) {
                        $isUsed = true;
                        break;
                    }
                }
                if (!$isUsed) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
    }

    public static function deleteStoredImages($class, $model, $type = null)
    {
        if ($type && $model->$type && $type !== 'gallery') {
            ImageService::deleteImage($class, $model, $type);
        }
        if ($model->gallery) {
            ImageService::deleteImages($class, $model);
        }
    }

    public static function storeOrUpdateGallery($request, $model, $type)
    {
        try {
            if ($request->hasFile($type)) {
                $files = is_array($request->file($type)) ? $request->file($type) : [$request->file($type)];
                return ImageService::processGalleryImages($files, $model, $type, 0, $request);
            }
            return response()->json(['success' => 'Images uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    private static function processGalleryImages($files, $model, $type, $maxFiles = 0, $request = null) // 0 means no limit
    {
        [$galleryPaths, $errors] = ImageService::save($files, strtolower(class_basename($model)), $type, $model->page_key, $request);
        if (!empty($errors)) {
            return response()->json(['error' => $errors], 400);
        }

        $error = ImageService::mergeImages($galleryPaths, $model, $type, $maxFiles, $request);

        if ($error) {
            return response()->json(['error' => $error], 400);
        }
        return response()->json(['success' => 'Images uploaded successfully']);
    }

    private static function save($files, $class, $type, $pageKey, $request = null)
    {
        $galleryPaths = [];
        $errors = [];
        $metadataNames = json_decode($request->input('metadata_names'), true);

        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
            $path = 'images/'.$class.'/'.$pageKey.'/'.$type;
            $relativePath = $path.'/' . $filename;

            if (Storage::disk('public')->exists($relativePath) || in_array($relativePath, $galleryPaths)) {
                $errors[] = "Het bestand $filename bestaat al.";
            } else {
                $filePath = $file->storeAs($path, $file->getClientOriginalName(), 'public');
                ProcessImageUpload::dispatch($filePath, $file->getClientOriginalName(), $path);

                $galleryPaths[] = [
                    'path' => $relativePath,
                    'created_at' => now()->toDateTimeString()
                ];

                foreach ($metadataNames as $metadata) {
                    $galleryPaths[count($galleryPaths) - 1][$metadata] = $request->input($metadata);
                }
            }
        }
        return [$galleryPaths, $errors];
    }

    private static function mergeImages($galleryPaths, $model, $type, $maxFiles, $request = null)
    {
        $error = null;
        if($model) {
            $existingImages = $model->$type ?? [];

            // Convert existing images to new format if they are just strings (paths)
            if (!empty($existingImages) && is_array($existingImages)) {
                foreach ($existingImages as $key => $value) {
                    if (is_string($value)) {
                        $existingImages[$key] = [
                            'path' => $value,
                            'created_at' => now()->toDateTimeString()
                        ];

                        foreach ($request->input('metadata_names') as $metadata) {
                            $existingImages[$key][$metadata] = $request->input($metadata);
                        }
                    }
                }
            }

            $mergedImages = array_merge($existingImages, $galleryPaths);

            if ($maxFiles > 0 && count($mergedImages) > $maxFiles) {
                $error = "De gallerij kan niet meer dan " . $maxFiles . " bestanden bevatten.";
                $mergedImages = array_slice($mergedImages, 0, $maxFiles);
            }
            $model->update([$type => empty($mergedImages) ? null : $mergedImages]);
        }
        return $error;
    }

    public static function fetchDropzoneImages($model, $type)
    {
        try {
            $files = [];
            if ($model) {
                $imageArray = is_array($model->$type) ? $model->$type : json_decode($model->$type, true);
                if (is_array($imageArray)) {
                    foreach ($imageArray as $imageData) {
                        // Handle both old format (string path) and new format (array with metadata)
                        $imagePath = is_string($imageData) ? $imageData : ($imageData['path'] ?? null);

                        if ($imagePath) {
                            $filePath = public_path($imagePath);
                            $file = [
                                'name' => basename($imagePath),
                                'size' => file_exists($filePath) ? filesize($filePath) : 0,
                                'path' => asset(Storage::url($imagePath)),
                            ];

                            // Add all metadata fields dynamically if they exist
                            if (is_array($imageData)) {
                                foreach ($imageData as $key => $value) {
                                    // Skip non-metadata fields
                                    if (!in_array($key, ['path', 'created_at'])) {
                                        $file[$key] = $value;
                                    }
                                }
                            }

                            $files[] = $file;
                        }
                    }
                }
            }
            return response()->json($files);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public static function deleteDropzoneImages($model, $request, $type)
    {
        try {
            ImageService::processGalleryDelete($model, $request, $type);
            return response()->json(['success' => 'Images deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    private static function processGalleryDelete($model, $request, $type)
    {
        $fileNames = $request->input('file_names', []);
        if ($model && is_array($model->$type)) {
            $normalizedFileNames = array_map('strtolower', array_map('trim', $fileNames));
            $updatedImages = array_filter($model->$type, function ($image) use ($type, $normalizedFileNames, $model) {
                // Handle both old format (string path) and new format (array with metadata)
                $imagePath = is_string($image) ? $image : ($image['path'] ?? null);

                if (!$imagePath) {
                    return false; // Remove invalid entries
                }

                $imageName = strtolower(basename($imagePath));
                if (in_array($imageName, $normalizedFileNames)) {
                    $isUsedInOtherModels = get_class($model)::where($type, 'like', '%' . $imageName . '%')
                        ->where('id', '!=', $model->id)
                        ->exists();
                    if (!$isUsedInOtherModels) {
                        Storage::disk('public')->delete($imagePath);
                    }
                    return false;
                }
                return true;
            });
            $model->update([$type => array_values($updatedImages)]);
        }
    }

    public static function processGalleryMetadata($request, $model)
    {
        $fileName = $request->input('file_name');
        $attribute = $request->input('attribute');
        $gallery = $model->$attribute;

        if (is_array($gallery)) {
            // Update the metadata for the specified file
            foreach ($gallery as $key => $imageData) {
                $imagePath = is_string($imageData) ? $imageData : ($imageData['path'] ?? null);
                $imageName = basename($imagePath);

                if ($imageName === $fileName) {
                    if (is_string($imageData)) {
                        $gallery[$key] = [
                            'path' => $imageData,
                            'created_at' => now()->toDateTimeString()
                        ];
                    }

                    // Get all request inputs except these specific ones
                    $excludedKeys = ['_token', 'file_name', 'attribute'];
                    foreach ($request->all() as $metadataKey => $metadataValue) {
                        if (!in_array($metadataKey, $excludedKeys)) {
                            $gallery[$key][$metadataKey] = $metadataValue;
                        }
                    }

                    break;
                }
            }
            $model->update([$attribute => $gallery]);

            return response()->json(['success' => 'Metadata updated successfully']);
        }

        return response()->json(['error' => 'Failed to update metadata'], 400);
    }
}
