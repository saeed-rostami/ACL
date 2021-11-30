<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',

    //index size
    'index-image-sizes' => [
        'large' => [
            'width' => 800,
            'height' => 800
        ],
         'medium' => [
            'width' => 480,
            'height' => 480
        ],
         'small' => [
            'width' => 240,
            'height' => 240
        ],

        'original' => [
            'width' => null,
            'height' => null,
        ],

    ],


];
