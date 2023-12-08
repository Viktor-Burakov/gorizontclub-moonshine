<?php

namespace App\Enums;

class ImageEnum
{
    const FULL_SIZE = [
        'dir' => 'original/',
        'width' => '2520',
        'height' => '2520',
    ];

    const BIG_SIZE = [
        'dir' => 'full/',
        'width' => '1920',
        'height' => '1920',
    ];

    const CONTAINER_SIZE = [
        'dir' => 'container/',
        'width' => '1120',
        'height' => '1120',
    ];

    const GALLERY_PREVIEW_SIZE = [
        'dir' => 'gallery_preview/',
        'width' => '360',
        'height' => '360',
    ];
}
