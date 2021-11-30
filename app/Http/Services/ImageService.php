<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    public function createIndexAndSave($image)
    {
        //get sizes from config
        $imageSizes = Config::get('image.index-image-sizes');

//        generate 5 random number
        $imageName = rand(10000, 90000);

        $indexArray = [];
        foreach ($imageSizes as $sizeAlias => $imageSize) {
            //create and set this size name
            $currentImageName = $imageName . '_' . $sizeAlias . '.' . $image->getClientOriginalName();

//            get original image default width and height
            list($defaultWidth, $defaultHeight) = $this->getDefaultSizes($image);


            //save image
            $result = Image::make($image->getRealPath())->fit($imageSize['width'] ?? $defaultWidth, $imageSize['height'] ?? $defaultHeight);

            Storage::disk('local')->put('images/' . '/' . $currentImageName, $result, 'public');

            if ($result)
                $indexArray[$sizeAlias] = storage_path('images/' . $currentImageName);
            else {
                return false;
            }
        }

        $images['indexArray'] = $indexArray;

        return $images;
    }

    /**
     * @param $image
     * @return array
     */
    protected function getDefaultSizes($image)
    {
        $defaultSize = getimagesize($image);
        $defaultWidth = $defaultSize[0];
        $defaultHeight = $defaultSize[1];
        return array($defaultWidth, $defaultHeight);
    }

}
