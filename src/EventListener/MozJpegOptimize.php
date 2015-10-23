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
     * @var
     */
    protected $quality;

    /**
     * @var
     */
    protected $tempDir;

    /**
     * @param string $mozJpgPath
     * @param int $quality
     * @param string $tempDir
     */
    public function __construct($mozJpgPath = '', $quality = 85, $tempDir = '/tmp/derby')
    {
        $this->mozJpgPath = $mozJpgPath;
        $this->quality = 85;
        $this->tempDir = $tempDir;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::IMAGE_PRE_SAVE => array('onImagePreSave', 0),
        );
    }

    /**
     * @param ImagePreSave $e
     */
    public function onImagePreSave(ImagePreSave $e)
    {
        $image = $e->getImage();

        if (!$this->mozJpgPath) {
            return;
        }

        if ($image->getFileExtension() != 'jpg' && $image->getFileExtension() != 'jpeg') {
            return;
        }

        /**
         * Copy to local
         */
        $source = $image->copyToLocal(uniqid() . '.jpg', $this->tempDir);
        $optimized = $image->copyToLocal(uniqid() . '.jpg', $this->tempDir);

        $safeSourcePath = escapeshellarg($source->getPath());
        $safeOptimizedPath = escapeshellarg($optimized->getPath());
        $safeQuality = escapeshellarg($this->quality);

        $cmd = $this->$mozJpgPath . '-outfile ' . $safeOptimizedPath . '  -quality ' . $safeQuality . ' ' . $safeSourcePath;
        exec($cmd);

        $image->load($optimized->read());
        $source->delete();
        $optimized->delete();
    }
}