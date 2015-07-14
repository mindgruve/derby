<?php

namespace Derby\Media\File;

use Derby\AdapterInterface;
use Derby\Exception\NoResizeDimensionsException;
use Derby\Media\File;
use Derby\Media\LocalFile;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Derby\Exception\InvalidImageException;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Palette\Color\ColorInterface;
use Imagine\Image\Point;

class Image extends File
{
    const THUMBNAIL_INSET = ImageInterface::THUMBNAIL_INSET;
    const THUMBNAIL_OUTBOUND = ImageInterface::THUMBNAIL_OUTBOUND;

    const DEFAULT_MODE = ImageInterface::THUMBNAIL_OUTBOUND;
    const DEFAULT_QUALITY = 75;


    const TYPE_MEDIA_FILE_IMAGE = 'MEDIA/FILE/IMAGE';

    /**
     * @var ImagineInterface
     */
    protected $imagine;

    /**
     * @var \Imagine\Image\AbstractImage
     */
    protected $image;

    /**
     * @var int
     */
    protected $quality = 75;


    public function __construct($key, AdapterInterface $adapter, ImagineInterface $imagine)
    {
        $this->imagine = $imagine;
        parent::__construct($key, $adapter);
    }


    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_IMAGE;
    }

    /**
     * In Memory representation of Image
     * @return \Imagine\Image\AbstractImage
     */
    public function getImage()
    {
        if (!$this->image) {
            $this->image = $this->imagine->load($this->read());
        }

        return $this->image;
    }

    public function setQuality($quality = self::DEFAULT_QUALITY)
    {
        $quality = (int)$quality;
        if ($quality < 0 || $quality > 100) {
            throw new \Exception('Quality must be between 0 and 100');
        }

        $this->quality = $quality;
    }

    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param Image $newFile
     * @return Image
     * @throws InvalidImageException
     */
    public function save(Image $newFile = null)
    {
        $image = $this->getImage();
        if ($newFile) {
            $target = $newFile;
        } else {
            $target = $this;
        }

        $extension = $target->getFileExtension();

        if (!$extension) {
            throw new InvalidImageException('No image extension');
        }

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $target->write($image->get('jpeg'), array('jpeg_quality' => $this->quality));
                break;
            case 'png':
                $pngCompression = floor($this->quality / 10);
                $target->write($image->get('png'), array('png_compression_level' => $pngCompression));
                break;
            default:
                throw new InvalidImageException('Invalid image extension');
        }

        return $target;
    }

    /**
     * @return ImagineInterface
     */
    public function getImagine()
    {
        return $this->imagine;
    }

    /**
     * @param $format
     */
    public function streamToBrowser($format = null)
    {
        if (!$format) {
            $format = $this->getFileExtension();
        }

        $this->getImage()->show($format);
    }

    /**
     * @param int $width
     * @param int $height
     * @param string $mode
     * @return $this
     * @throws NoResizeDimensionsException
     */
    public function resize($width = 0, $height = 0, $mode = self::DEFAULT_MODE)
    {

        // if we were provided both width and height then we know the size of the new image
        // otherwise we resize proportionally.
        if ($width > 0 && $height > 0) {
            $size = new Box($width, $height);
        } elseif ($width > 0) {
            $size = $this->getImage()
                ->getSize()
                ->widen($width);
        } elseif ($height > 0) {
            $size = $this->getImage()
                ->getSize()
                ->heighten($height);
        } else {
            throw new NoResizeDimensionsException('You must provide $width and/or $height to resize an image');
        }

        $this->image = $this->getImage()->thumbnail($size, $mode);

        return $this;
    }

    /**
     * @param $x
     * @param $y
     * @param $height
     * @param $width
     * @return $this
     */
    public function crop($x, $y, $height, $width)
    {

        $x = (int)$x;
        $y = (int)$y;
        $height = (int)$height;
        $width = (int)$width;

        $point = new Point($x, $y);
        $box = new Box($height, $width);

        $this->getImage()->crop($point, $box);
        return $this;
    }

    /**
     * @param $angle
     * @param ColorInterface $background
     * @return $this
     */
    public function rotate($angle, ColorInterface $background = null)
    {
        $this->image = $this->getImage()->rotate($angle, $background);
        return $this;
    }

    /**
     * @return $this
     */
    public function greyscale()
    {
        $this->getImage()->effects()->grayscale();
        return $this;
    }

    /**
     * @return $this
     */
    public function flipHorizontally()
    {
        $this->getImage()->flipHorizontally();

        return $this;
    }

    /**
     * @return $this
     */
    public function flipVertically()
    {
        $this->getImage()->flipVertically();

        return $this;
    }

    /**
     * Get width
     * @return int
     */
    public function getWidth()
    {
        return $this->getImage()->getSize()->getWidth();
    }

    /**
     * Get heigth
     * @return int
     */
    public function getHeight()
    {
        return $this->getImage()->getSize()->getHeight();
    }
}
