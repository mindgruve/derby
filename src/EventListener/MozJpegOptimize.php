<?php

namespace Derby\EventListener;

use Derby\Event\ImagePreSave;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Derby\Events;

class MozJpegOptimize implements EventSubscriberInterface
{

    /**
     * @var string
     */
    protected $mozJpgPath;

    /**
     * @var string
     */
    protected $tempDir;

    /**
     * @param string $mozJpgPath
     * @param string $tempDir
     */
    public function __construct($mozJpgPath = '',  $tempDir = '/tmp/derby')
    {
        $this->mozJpgPath = $mozJpgPath;
        $this->tempDir = $tempDir;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::IMAGE_PRE_SAVE => array('onMediaImagePreSave', 0),
        );
    }

    /**
     * @param ImagePreSave $e
     */
    public function onMediaImagePreSave(ImagePreSave $e)
    {
        $image = $e->getImage();

        if (!$this->mozJpgPath) {
            return;
        }

        if ($image->getFileExtension() != 'jpg' && $image->getFileExtension() != 'jpeg') {
            return;
        }

        if($image->getQuality() >= 100){
            return;
        }

        /**
         * Copy to local
         */
        $uniqid = uniqid();
        $source = $image->copyToLocal($uniqid . $image->getFileExtension(), $this->tempDir);
        $optimized = $image->copyToLocal($uniqid . '-optimized.jpg', $this->tempDir);

        /**
         * Optimize
         */
        $safeSourcePath = escapeshellarg($source->getPath());
        $safeOptimizedPath = escapeshellarg($optimized->getPath());
        $safeQuality = escapeshellarg($image->getQuality());

        $cmd = $this->mozJpgPath . ' -outfile ' . $safeOptimizedPath . '  -quality ' . $safeQuality . ' ' . $safeSourcePath;
        exec($cmd);

        /**
         * Replace Image
         */
        if($source->getSize() > $optimized->getSize() && $optimized->getSize() != 0){
            $image->load($optimized->read());
        }

        /**
         * Cleanup
         */
        $source->delete();
        $optimized->delete();
    }
}