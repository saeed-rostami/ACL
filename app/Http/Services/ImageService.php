<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    public function createIndexAndSave($image)
    {
        //get data from config
        $imageSizes = Config::get('image.index-image-sizes');

        $uuid = rand(10000, 90000);
        $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

        $indexArray = [];
        foreach ($imageSizes as $sizeAlias => $imageSize) {

//            create and set this size name
            $currentImageName = $uuid . '_' . $imageName;

            list($defaultWidth, $defaultHeight) = $this->getDefaultSizes($image);

            $fileName = $sizeAlias . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            $img->fit($imageSize['width'] ?? $defaultWidth, $imageSize['height'] ?? $defaultHeight);

            $img->stream(); // <-- Key point

            Storage::disk('local')->put('images/' . $currentImageName . '/' . $fileName, $img, 'public');

            if ($img)
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
