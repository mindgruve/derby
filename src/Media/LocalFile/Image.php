<?php

namespace Derby\Media\LocalFile;

use Derby\Adapter\LocalFileAdapter;
use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Exception\NoResizeDimensionsException;
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

    const DEFAULT_MODE = ImageInterface::THUMBNAIL_OUTBOUND;
    const DEFAULT_QUALITY = 75;


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
     * @param LocalFileAdapter $adapter
     * @param int $width
     * @param int $height
     * @param string $mode
     * @param int $quality
     * @return Image
     * @throws InvalidImageException
     * @throws NoResizeDimensionsException
     */
    public function resize($key, LocalFileAdapter $adapter, $width = 0, $height = 0, $mode = self::DEFAULT_MODE, $quality = self::DEFAULT_QUALITY)
    {

        if (!$adapter) {
            $adapter = $this->getAdapter();
        }

        // if we were provided both width and height then we know the size of the new image
        // otherwise we resize proportionally.
        if ($width > 0 && $height > 0) {
            $size = new Box($width, $height);
        } elseif ($width > 0) {
            $size = $this->imagine
                ->open($this->getPath())
                ->getSize()
                ->widen($width);
        } elseif ($height > 0) {
            $size = $this->imagine
                ->open($this->getPath())
                ->getSize()
                ->heighten($height);
        } else {
            throw new NoResizeDimensionsException('You must provide $width and/or $height to resize an image');
        }

        $image = $this->imagine
            ->open($this->getPath())
            ->thumbnail($size, $mode);

        $target = new Image($key, $adapter, $this->imagine);
        $extension = $target->getFileExtension();

        if (!$extension) {
            throw new InvalidImageException('No image extension');
        }

        switch ($extension) {
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
     * @param LocalFileAdapter $adapter
     * @param Point $point
     * @param Box $box
     * @return Image
     */
    public function crop($key, LocalFileAdapter $adapter, Point $point, Box $box)
    {
        if (!$adapter) {
            $adapter = $this->getAdapter();
        }

        $target = new Image($key, $adapter, $this->imagine);

        $this->imagine->open($this->getPath())->crop($point, $box)->save($target->getPath());

        return $target;
    }

    /**
     * @param $key
     * @param LocalFileAdapter $adapter
     * @param $degrees
     * @return Image
     */
    public function rotate($key, LocalFileAdapter $adapter, $degrees)
    {

        if (!$adapter) {
            $adapter = $this->getAdapter();
        }

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
        if (!$adapter) {
            $adapter = $this->getAdapter();
        }

        $target = new Image($key, $adapter, $this->imagine);
        $image = $this->imagine->open($this->getPath());
        $image->effects()->grayscale();
        $image->save($target->getPath());
    }

    /**
     * @param $key
     * @param LocalFileAdapterInterface $adapter
     */
    public function flipHorizontally($key, LocalFileAdapterInterface $adapter)
    {
        if (!$adapter) {
            $adapter = $this->getAdapter();
        }

        $target = new Image($key, $adapter, $this->imagine);
        $this->imagine->open($this->getPath())->flipHorizontally()->save($target->getPath());
    }

    /**
     * @param $key
     * @param LocalFileAdapterInterface $adapter
     */
    public function flipVertically($key, LocalFileAdapterInterface $adapter)
    {
        if (!$adapter) {
            $adapter = $this->getAdapter();
        }

        $target = new Image($key, $adapter, $this->imagine);
        $this->imagine->open($this->getPath())->flipVertically()->save($target->getPath());
    }

    /**
     * Get width
     * @return int
     */
    public function getWidth()
    {
        return $this->imagine->open($this->getPath())->getSize()->getWidth();
    }

    /**
     * Get heigth
     * @return int
     */
    public function getHeight()
    {
        return $this->imagine->open($this->getPath())->getSize()->getHeight();
    }

    /**
     * @return ImagineInterface
     */
    public function getImagine()
    {
        return $this->imagine;
    }

    public function streamToBrowser()
    {
        switch ($this->getFileExtension()) {
            case 'png':
                $im = imagecreatefrompng($this->getPath());
                header('Content-Type: image/png');
                imagepng($im);
                imagedestroy($im);
                exit;
                break;
            case 'jpeg':
            case 'jpg':
                $im = imagecreatefromjpeg($this->getPath());
                header('Content-Type: image/jpeg');
                imagejpeg($im);
                imagedestroy($im);
                exit;
                break;
            case 'gif':
                $im = imagecreatefromgif($this->getPath());
                header('Content-Type: image/jpeg');
                imagegif($im);
                imagedestroy($im);
                break;
        }
    }
}
