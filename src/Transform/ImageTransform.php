<?php

namespace Derby\Transform;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\AbstractImagine;
use Derby\Exception\InvalidImageException;
use Imagine\Image\Point;

class ImageTransform
{

    const THUMBNAIL_INSET = ImageInterface::THUMBNAIL_INSET;
    const THUMBNAIL_OUTBOUND = ImageInterface::THUMBNAIL_OUTBOUND;

    /**
     * @var AbstractImagine
     */
    protected $imagine;

    public function __construct(AbstractImagine $imagine)
    {
        $this->imagine = new $imagine;
    }

    public function resize($sourceFile, $targetFile, $width, $height, $mode = self::THUMBNAIL_INSET, $quality = 75)
    {
        $size  = new Box($width, $height);
        $image = $this->imagine->open($sourceFile)
            ->thumbnail($size, $mode);

        $pathInfo = pathinfo(strtolower($targetFile));

        if (!isset($pathInfo['extension'])) {
            throw new InvalidImageException('No image extension');
        }

        switch ($pathInfo['extension']) {
            case 'jpg':
            case 'jpeg':
                $image->save($targetFile, array('jpeg_quality' => $quality));
                break;
            case 'png':
                $pngCompression = floor($quality / 10);
                $image->save($targetFile, array('png_compression_level' => $pngCompression));
                break;
            default:
                throw new InvalidImageException('Invalid image extension');
        }
    }

    public function crop($sourceFile, $targetFile, Point $start, Box $size)
    {
        $this->imagine->open($sourceFile)->crop($start, $size)->save($targetFile);
    }

    public function rotate($sourceFile, $targetFile, $degrees)
    {
        $this->imagine->open($sourceFile)->rotate($degrees)->save($targetFile);
    }

    public function greyscale($sourceFile, $targetFile)
    {
        $image = $this->imagine->open($sourceFile);
        $image->effects()->grayscale();
        $image->save($targetFile);
    }

    public function flipHorizontally($sourceFile, $targetFile)
    {
        $this->imagine->open($sourceFile)->flipHorizontally()->save($targetFile);
    }

    public function flipVertically($sourceFile, $targetFile)
    {
        $this->imagine->open($sourceFile)->flipVertically()->save($targetFile);
    }
}
