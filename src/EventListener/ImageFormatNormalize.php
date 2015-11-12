<?php

namespace Derby\EventListener;

use Derby\Event\ImagePreLoad;
use Derby\Events;
use Derby\Media\File\LocalFile;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ImageFormatNormalize implements EventSubscriberInterface
{

    /**
     * @var string
     */
    protected $tempDir;

    /**
     * @var array
     */
    protected $formats;

    /**
     * @var string
     */
    protected $imageMagickConvert;

    public function __construct($tempDir, $imageMagickConvert, array $formats)
    {
        $this->tempDir = $tempDir;
        $this->formats = $formats;
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
        $originalExtension = strtolower($image->getFileExtension());

        if (!array_key_exists($originalExtension, $this->formats)) {
            return;
        }

        $newExtension = $this->formats[$originalExtension];

        /**
         * Copy to local
         */
        $uniqid = uniqid();
        $source = new LocalFile($uniqid . '.' . $originalExtension, $this->tempDir);
        $normalized = new LocalFile($uniqid . '-normalized.' . $newExtension, $this->tempDir);
        $source->write($image->read());

        /**
         * Normalize
         */
        $safeSourcePath = escapeshellarg($source->getPath());
        $safeNormalizedPath = escapeshellarg($normalized->getPath());

        $cmd = $this->imageMagickConvert . ' ' . $safeSourcePath . ' ' . $safeNormalizedPath;
        exec($cmd);

        if ($normalized->exists() && $normalized->getSize() > 0) {
            $image->setImageData($normalized->read());
            $image->setKey($image->getKeyWithExtension($newExtension));
        }

        $source->delete();
        $normalized->delete();
    }
}