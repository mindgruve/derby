<?php

namespace Derby\Media\File;

use Derby\Media\Box;
use Derby\Media\ImageTransform;
use Derby\Media\Local;
use Derby\Media\LocalFile;
use Derby\Media\Point;

class Image extends LocalFile
{
    const TYPE_MEDIA_FILE_IMAGE = 'MEDIA\LOCAL\IMAGE';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_IMAGE;
    }

    /**
     * @param $key
     * @param $width
     * @param $height
     * @param string $mode
     * @param int $quality
     * @return mixed
     */
    public function resize($key, $width, $height, $mode = ImageTransform::THUMBNAIL_OUTBOUND, $quality = 75)
    {
        // TODO: Implement resize() method.
    }

    /**
     * @param $key
     * @param Point $point
     * @param Box $box
     * @return mixed
     */
    public function crop($key, Point $point, Box $box)
    {
        // TODO: Implement crop() method.
    }

    /**
     * @param $key
     * @param $degrees
     * @return mixed
     */
    public function rotate($key, $degrees)
    {
        // TODO: Implement rotate() method.
    }

    /**
     * @param $key
     * @return mixed
     */
    public function greyscale($key)
    {
        // TODO: Implement greyscale() method.
    }

    /**
     * @param $key
     * @return mixed
     */
    public function flipHorizontally($key)
    {
        // TODO: Implement flipHorizontally() method.
    }

    /**
     * @param $key
     * @return mixed
     */
    public function flipVertically($key)
    {
        // TODO: Implement flipVertically() method.
    }
}
