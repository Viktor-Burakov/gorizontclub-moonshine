<?php

namespace App\Enums;

class ImageEnum
{
    const FULL = [
        'dir' => 'images_test/original/',
        'width' => '2520',
        'height' => '2520',
    ];

    const BIG = [
        'dir' => 'images_test/full/',
        'width' => '1920',
        'height' => '1920',
    ];

    const CONTAINER = [
        'dir' => 'images_test/container/',
        'width' => '1120',
        'height' => '1120',
    ];

    const GALLERY_PREVIEW = [
        'dir' => 'images_test/gallery_preview/',
        'width' => '360',
        'height' => '360',
    ];
}
