<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class MediaUploadController extends Controller
{
    /**
     * Upload an image file, convert to optimized WebP, and return its public URL.
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
        ]);

        $file = $request->file('file');
        $filename = Str::random(24) . '_' . time();

        try {
            // Decode uploaded image
            $image = Image::decode($file->getPathname());

            // Constrain dimensions proportionally without exceeding 1600px
            $image->scaleDown(width: 1600, height: 1600);

            // Encode as WebP with 85% quality
            $encoded = $image->encodeUsingFileExtension('webp', quality: 85);

            // Store to public disk
            $path = "uploads/{$filename}.webp";
            Storage::disk('public')->put($path, (string) $encoded);

            return response()->json([
                'url' => "/storage/{$path}",
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Unable to decode and process image file. The image may be corrupted.',
            ], 422);
        }
    }
}
