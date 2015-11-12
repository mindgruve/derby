<?php

namespace Derby\EventListener;

use Derby\Event\ImagePreLoad;
use Derby\Events;
use Derby\Media\File\LocalFile;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ImageMaxDimensions implements EventSubscriberInterface
{
    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var int
     */
    protected $maxWidth;

    /**
     * @var int
     */
    protected $maxHeight;

    /**
     * @var string
     */
    protected $tempDir;

    /**
     * @var string
     */
    protected $imageMagickConvert;

    /**
     * @param $tempDir
     * @param $imageMagickConvert
     * @param $width
     * @param $height
     * @param null $maxWidth
     * @param null $maxHeight
     * @throws \Exception
     */
    public function __construct($tempDir, $imageMagickConvert, $width, $height, $maxWidth, $maxHeight)
    {
        $this->tempDir = $tempDir;
        $this->height = (int)$height;
        $this->width = (int)$width;
        $this->imageMagickConvert = $imageMagickConvert;
        $this->maxWidth = (int)$maxWidth;
        $this->maxHeight = (int)$maxHeight;

        if ($height <= 0 || $width <= 0) {
            throw new \Exception('Height/Width for image dimensions should be a positive integer');
        }

        if ($maxHeight <= 0 || $maxWidth <= 0) {
            throw new \Exception('Max Height/Width for image dimensions should be a positive integer');
        }


    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::IMAGE_PRE_LOAD => array('onMediaImagePreLoad', 0),
        );
    }

    public function onMediaImagePreLoad(ImagePreLoad $e)
    {
        $image = $e->getImage();
        $uniqid = uniqid();
        $resized = new LocalFile($uniqid . '-resized.jpg', $this->tempDir);

        $source = $image->copyToLocal($uniqid, $this->tempDir);
        $sourcePath = $source->getPath();
        $imageSize = getimagesize($sourcePath);

        $width = $imageSize[0];
        $height = $imageSize[1];

        if ($width <= $this->width && $height <= $this->height) {
            return;
        }

        if ($width >= $this->maxWidth || $height >= $this->maxWidth) {
            throw new \Exception('Image dimensions to large to resize');
        }

        $safeSourcePath = escapeshellarg($sourcePath);
        $safeResizedPath = escapeshellarg($resized->getPath());
        $cmd = $this->imageMagickConvert . ' ' . $safeSourcePath . ' -resize ' . $this->width . 'x' . $this->height . '\> ' . $safeResizedPath;
        exec($cmd);

        if ($resized->exists() && $resized->getSize() > 0) {
            $image->setImageData($resized->read());
        }

        $source->delete();
        $resized->delete();
    }
}