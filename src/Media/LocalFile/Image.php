<?php

namespace Derby\Media\LocalFile;

use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Media\Local;
use Derby\Media\LocalFile;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Derby\Exception\InvalidImageException;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Point;

class Image extends LocalFile
{
    const THUMBNAIL_INSET = ImageInterface::THUMBNAIL_INSET;
    const THUMBNAIL_OUTBOUND = ImageInterface::THUMBNAIL_OUTBOUND;


    const TYPE_MEDIA_FILE_IMAGE = 'MEDIA\LOCAL\IMAGE';

    /**
     * @var ImagineInterface
     */
    protected $imagine;

    public function __construct($key, LocalFileAdapterInterface $adapter, ImagineInterface $imagine)
    {
        $this->imagine = $imagine;
        parent::__construct($key, $adapter);
    }


    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_IMAGE;
    }

    /**
     * @param $key
     * @param $adapter
     * @param $width
     * @param $height
     * @param string $mode
     * @param int $quality
     * @return Image
     * @throws InvalidImageException
     */
    public function resize($key, $adapter, $width, $height, $mode = ImageInterface::THUMBNAIL_OUTBOUND, $quality = 75)
    {
        $target = new Image($key, $adapter, $this->imagine);

        $size  = new Box($width, $height);
        $image = $this->imagine->open($this->getPath())
            ->thumbnail($size, $mode);

        $pathInfo = pathinfo(strtolower($target->getPath()));

        if (!isset($pathInfo['extension'])) {
            throw new InvalidImageException('No image extension');
        }

        switch ($pathInfo['extension']) {
            case 'jpg':
            case 'jpeg':
                $image->save($target->getPath(), array('jpeg_quality' => $quality));
                break;
            case 'png':
                $pngCompression = floor($quality / 10);
                $image->save($target->getPath(), array('png_compression_level' => $pngCompression));
                break;
            default:
                throw new InvalidImageException('Invalid image extension');
        }

        return $target;
    }

    /**
     * @param $key
     * @param LocalFileAdapterInterface $adapter
     * @param Point $point
     * @param Box $box
     * @return Image
     */
    public function crop($key, LocalFileAdapterInterface $adapter,  Point $point, Box $box)
    {
        $target = new Image($key, $adapter, $this->imagine);

        $this->imagine->open($this->getPath())->crop($point, $box)->save($target->getPath());

        return $target;
    }

    /**
     * @param $key
     * @param LocalFileAdapterInterface $adapter
     * @param $degrees
     * @return Image
     */
    public function rotate($key, LocalFileAdapterInterface $adapter, $degrees)
    {
        $target = new Image($key, $adapter, $this->imagine);
        $this->imagine->open($this->getPath())->rotate($degrees)->save($target->getPath());

        return $target;
    }

    /**
     * @param $key
     * @param LocalFileAdapterInterface $adapter
     */
    public function greyscale($key, LocalFileAdapterInterface $adapter)
    {
        $target = new Image($key, $adapter, $this->imagine);
        $image  = $this->imagine->open($this->getPath());
        $image->effects()->grayscale();
        $image->save($target->getPath());
    }

    /**
     * @param $key
     * @param LocalFileAdapterInterface $adapter
     */
    public function flipHorizontally($key, LocalFileAdapterInterface $adapter)
    {
        $target = new Image($key, $adapter, $this->imagine);
        $this->imagine->open($this->getPath())->flipHorizontally()->save($target->getPath());
    }

    /**
     * @param $key
     * @param LocalFileAdapterInterface $adapter
     */
    public function flipVertically($key,LocalFileAdapterInterface $adapter)
    {
        $target = new Image($key, $adapter, $this->imagine);
        $this->imagine->open($this->getPath())->flipVertically()->save($target->getPath());
    }
}
