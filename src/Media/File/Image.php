<?php

namespace Derby\Media\File;

use Derby\AdapterInterface;
use Derby\Event\ImagePostLoad;
use Derby\Event\ImagePostSave;
use Derby\Event\ImagePreLoad;
use Derby\Event\ImagePreSave;
use Derby\Events;
use Derby\Exception\NoResizeDimensionsException;
use Derby\Media\File;
use Derby\Media\LocalFile;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Derby\Exception\InvalidImageException;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Palette\Color\ColorInterface;
use Imagine\Image\Point;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Image extends File
{
    const THUMBNAIL_INSET = ImageInterface::THUMBNAIL_INSET;
    const THUMBNAIL_OUTBOUND = ImageInterface::THUMBNAIL_OUTBOUND;

    const DEFAULT_MODE = ImageInterface::THUMBNAIL_OUTBOUND;
    const DEFAULT_QUALITY = 100;

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
    protected $quality = 100;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param $key
     * @param AdapterInterface $adapter
     * @param ImagineInterface $imagine
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct($key, AdapterInterface $adapter, ImagineInterface $imagine, EventDispatcherInterface $dispatcher = null)
    {
        $this->imagine = $imagine;
        $this->dispatcher = $dispatcher;
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
    public function getInMemoryImage()
    {
        if (!$this->image) {
            $this->image = $this->load($this->read());
        }

        return $this->image;
    }

    /**
     * @param $data
     * @return ImageInterface
     */
    public function load($data)
    {
        $this->dispatchPreLoad($this);
        $return = $this->imagine->load($data);
        $this->dispatchPostLoad($this);

        return $return;
    }

    /**
     * @param int $quality
     * @throws \Exception
     */
    public function setQuality($quality = self::DEFAULT_QUALITY)
    {
        $quality = (int)$quality;
        if ($quality < 0 || $quality > 100) {
            throw new \Exception('Quality must be between 0 and 100');
        }

        $this->quality = $quality;
    }

    /**
     * @return int
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param Image $newFile
     * @return Image
     * @throws InvalidImageException
     */
    public function save(Image $newFile = null, $quality = null)
    {
        if ($quality) {
            $this->setQuality($quality);
        }

        /**
         * DISPATCH PRE-SAVE
         */
        $this->dispatchPreSave($this);

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
                $target->write($this->getInMemoryImage()->get('jpeg'));
                break;
            case 'png':
                $target->write($this->getInMemoryImage()->get('png'));
                break;
            default:
                throw new InvalidImageException('Invalid image extension');
        }

        /**
         * DISPATCH POST-SAVE
         */
        $this->dispatchPostSave($target);

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

        $this->getInMemoryImage()->show($format);
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
            $size = $this->getInMemoryImage()
                ->getSize()
                ->widen($width);
        } elseif ($height > 0) {
            $size = $this->getInMemoryImage()
                ->getSize()
                ->heighten($height);
        } else {
            throw new NoResizeDimensionsException('You must provide $width and/or $height to resize an image');
        }

        $this->image = $this->getInMemoryImage()->thumbnail($size, $mode);

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

        $this->getInMemoryImage()->crop($point, $box);
        return $this;
    }

    /**
     * @param $angle
     * @param ColorInterface $background
     * @return $this
     */
    public function rotate($angle, ColorInterface $background = null)
    {
        $this->image = $this->getInMemoryImage()->rotate($angle, $background);
        return $this;
    }

    /**
     * @return $this
     */
    public function greyscale()
    {
        $this->getInMemoryImage()->effects()->grayscale();
        return $this;
    }

    /**
     * @return $this
     */
    public function flipHorizontally()
    {
        $this->getInMemoryImage()->flipHorizontally();

        return $this;
    }

    /**
     * @return $this
     */
    public function flipVertically()
    {
        $this->getInMemoryImage()->flipVertically();

        return $this;
    }

    /**
     * Get width
     * @return int
     */
    public function getWidth()
    {
        return $this->getInMemoryImage()->getSize()->getWidth();
    }

    /**
     * Get heigth
     * @return int
     */
    public function getHeight()
    {
        return $this->getInMemoryImage()->getSize()->getHeight();
    }

    /**
     * @return ImagePreSave
     */
    protected function dispatchPreSave(Image $image)
    {
        $event = new ImagePreSave($image);
        if ($this->dispatcher) {
            return $this->dispatcher->dispatch(Events::IMAGE_PRE_SAVE, $event);
        }
        return $event;
    }

    /**
     * @return ImagePostSave
     */
    protected function dispatchPostSave(Image $image)
    {
        $event = new ImagePostSave($image);
        if ($this->dispatcher) {
            return $this->dispatcher->dispatch(Events::IMAGE_POST_SAVE, $event);
        }
        return $event;
    }

    /**
     * @param Image $image
     * @return ImagePreLoad|\Symfony\Component\EventDispatcher\Event
     */
    public function dispatchPreLoad(Image $image)
    {
        $event = new ImagePreLoad($image);
        if ($this->dispatcher) {
            return $this->dispatcher->dispatch(Events::IMAGE_PRE_LOAD, $event);
        }
        return $event;
    }

    /**
     * @param Image $image
     * @return ImagePostLoad|\Symfony\Component\EventDispatcher\Event
     */
    public function dispatchPostLoad(Image $image)
    {
        $event = new ImagePostLoad($image);
        if ($this->dispatcher) {
            return $this->dispatcher->dispatch(Events::IMAGE_POST_LOAD, $event);
        }
        return $event;
    }
}
