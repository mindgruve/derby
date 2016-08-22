<?php

namespace Derby\Media\File;

use Derby\Adapter\AdapterInterface;
use Derby\Event\ImagePostLoad;
use Derby\Event\ImagePostSave;
use Derby\Event\ImagePreLoad;
use Derby\Event\ImagePreSave;
use Derby\Events;
use Derby\Exception\DerbyException;
use Derby\Exception\NoResizeDimensionsException;
use Derby\Media\File;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
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
     * @var float
     */
    protected $focusPointX = 0;

    /**
     * @var float
     */
    protected $focusPointY = 0;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param $mediaKey
     * @param AdapterInterface $adapter
     * @param ImagineInterface $imagine
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        $mediaKey,
        AdapterInterface $adapter,
        ImagineInterface $imagine,
        EventDispatcherInterface $dispatcher = null
    ) {
        $this->imagine = $imagine;
        $this->dispatcher = $dispatcher;
        parent::__construct($mediaKey, $adapter);
    }


    public function load()
    {
        $this->dispatchPreLoad($this);
        if (!$this->image) {
            $this->setImageData($this->read());
        }
        $this->dispatchPostLoad($this);

        return $this;
    }

    /**
     * @param $data
     * @return ImageInterface
     */
    public function setImageData($data)
    {
        $this->image = $this->imagine->load($data);

        return $this;
    }

    /**
     * In Memory representation of Image
     * @return \Imagine\Image\AbstractImage
     */
    public function getImageData($format = null)
    {
        if (!$this->image) {
            $this->load();
        }

        if ($format) {
            return $this->image->get($format);
        }

        return $this->image;
    }

    /**
     * @param int $quality
     * @throws DerbyException
     */
    public function setQuality($quality = self::DEFAULT_QUALITY)
    {
        $quality = (int)$quality;
        if ($quality < 0 || $quality > 100) {
            throw new DerbyException('Quality must be between 0 and 100');
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
                $target->write($this->getImageData('jpeg'));
                break;
            case 'png':
                $target->write($this->getImageData('png'));
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

        $this->getImageData()->show($format);
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
            $size = $this->getImageData()
                ->getSize()
                ->widen($width);
        } elseif ($height > 0) {
            $size = $this->getImageData()
                ->getSize()
                ->heighten($height);
        } else {
            throw new NoResizeDimensionsException('You must provide $width and/or $height to resize an image');
        }

        $this->image = $this->getImageData()->thumbnail($size, $mode);

        return $this;
    }

    public function convertFocusPointX()
    {
        $width = $this->getImageData()->getSize()->getWidth();

        return ($this->focusPointX + 1) * ($width / 2);
    }

    public function convertFocusPointY()
    {
        $height = $this->getImageData()->getSize()->getHeight();

        return $height - ($this->focusPointY + 1) * ($height / 2);
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

        $this->getImageData()->crop($point, $box);

        return $this;
    }

    /**
     * @param $angle
     * @param ColorInterface $background
     * @return $this
     */
    public function rotate($angle, ColorInterface $background = null)
    {
        $this->image = $this->getImageData()->rotate($angle, $background);

        return $this;
    }

    /**
     * @return $this
     */
    public function greyscale()
    {
        $this->getImageData()->effects()->grayscale();

        return $this;
    }

    /**
     * @return $this
     */
    public function flipHorizontally()
    {
        $this->getImageData()->flipHorizontally();

        return $this;
    }

    /**
     * @return $this
     */
    public function flipVertically()
    {
        $this->getImageData()->flipVertically();

        return $this;
    }

    /**
     * Get width
     * @return int
     */
    public function getWidth()
    {
        return $this->getImageData()->getSize()->getWidth();
    }

    /**
     * Get heigth
     * @return int
     */
    public function getHeight()
    {
        return $this->getImageData()->getSize()->getHeight();
    }

    /**
     * @return ImagePreSave
     */
    protected function dispatchPreSave(Image $image)
    {
        $event = new ImagePreSave($image);
        if ($this->dispatcher) {
            $this->dispatcher->dispatch(Events::IMAGE_PRE_SAVE, $event);
        }

        return $this;
    }

    /**
     * @return ImagePostSave
     */
    protected function dispatchPostSave(Image $image)
    {
        $event = new ImagePostSave($image);
        if ($this->dispatcher) {
            $this->dispatcher->dispatch(Events::IMAGE_POST_SAVE, $event);
        }

        return $this;
    }

    /**
     * @param Image $image
     * @return ImagePreLoad|\Symfony\Component\EventDispatcher\Event
     */
    public function dispatchPreLoad(Image $image)
    {
        $event = new ImagePreLoad($image);
        if ($this->dispatcher) {
            $this->dispatcher->dispatch(Events::IMAGE_PRE_LOAD, $event);
        }

        return $this;
    }

    /**
     * @param Image $image
     * @return ImagePostLoad|\Symfony\Component\EventDispatcher\Event
     */
    public function dispatchPostLoad(Image $image)
    {
        $event = new ImagePostLoad($image);
        if ($this->dispatcher) {
            $this->dispatcher->dispatch(Events::IMAGE_POST_LOAD, $event);
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getFocusPointX()
    {
        return $this->focusPointX;
    }

    /**
     * @param $focusPointX
     * @return $this
     * @throws DerbyException
     */
    public function setFocusPointX($focusPointX)
    {
        if ($focusPointX < -1 || $focusPointX > 1) {
            throw new DerbyException('FocusPointX should be between -1 and 1');
        }

        $this->focusPointX = $focusPointX;

        return $this;
    }

    /**
     * @return float
     */
    public function getFocusPointY()
    {
        return $this->focusPointY;
    }

    /**
     * @param $focusPointY
     * @return $this
     * @throws DerbyException
     */
    public function setFocusPointY($focusPointY)
    {
        if ($focusPointY < -1 || $focusPointY > 1) {
            throw new DerbyException('FocusPointY should be between -1 and 1');
        }

        $this->focusPointY = $focusPointY;

        return $this;
    }


}
