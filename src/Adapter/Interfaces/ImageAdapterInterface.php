<?php

namespace Derby\Adapter\Interfaces;

use Derby\AdapterInterface;
use Derby\Transform\ImageTransform;
use Imagine\Image\Box;
use Imagine\Image\Point;

interface ImageAdapterInterface extends AdapterInterface
{
    /**
     * @param $key
     * @param $width
     * @param $height
     * @param string $mode
     * @param int $quality
     * @return mixed
     */
    public function resize($key, $width, $height, $mode = ImageTransform::THUMBNAIL_OUTBOUND, $quality = 75);

    /**
     * @param $key
     * @param Point $point
     * @param Box $box
     * @return mixed
     */
    public function crop($key, Point $point, Box $box);

    /**
     * @param $key
     * @param $degrees
     * @return mixed
     */
    public function rotate($key, $degrees);

    /**
     * @param $key
     * @return mixed
     */
    public function greyscale($key);

    /**
     * @param $key
     * @return mixed
     */
    public function flipHorizontally($key);

    /**
     * @param $key
     * @return mixed
     */
    public function flipVertically($key);
}
