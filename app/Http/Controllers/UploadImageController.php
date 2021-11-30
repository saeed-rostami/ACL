<?php

namespace App\Http\Controllers;

use App\Http\Services\ImageService;
use Illuminate\Http\Request;

class UploadImageController extends Controller
{
    public function upload(Request $request, ImageService $imageService)
    {
        $image = $request->file('image');
        $imageService->createIndexAndSave($image);
    }
}
