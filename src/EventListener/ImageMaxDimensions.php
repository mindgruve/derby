<?php

namespace Derby\EventListener;

use Derby\Event\ImagePreLoad;
use Derby\Events;
use Derby\Media\File\LocalFile;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ImageMaxDimensions implements EventSubscriberInterface
{
    /**
     * @var int|null
     */
    protected $maxWidth;

    /**
     * @var int|null
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
     * @param null $maxWidth
     * @param null $maxHeight
     */
    public function __construct($tempDir, $imageMagickConvert, $maxWidth, $maxHeight)
    {
        $this->tempDir = $tempDir;
        $this->maxHeight = (int)$maxHeight;
        $this->maxWidth = (int)$maxWidth;
        $this->imageMagickConvert = $imageMagickConvert;
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

        if ($width <= $this->maxWidth && $height <= $this->maxHeight) {
            return;
        }

        $safeSourcePath = escapeshellarg($sourcePath);
        $safeResizedPath = escapeshellarg($resized->getPath());
        $cmd = $this->imageMagickConvert . ' ' . $safeSourcePath . ' -resize ' . $this->maxWidth . 'x' . $this->maxHeight . '\> ' . $safeResizedPath;
        exec($cmd);

        if ($resized->exists() && $resized->getSize() > 0) {
            $image->setImageData($resized->read());
        }

        $source->delete();
        $resized->delete();
    }
}