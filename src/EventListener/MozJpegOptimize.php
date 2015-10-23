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
     * @var int
     */
    protected $quality;

    /**
     * @var string
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
        $this->quality = $quality;
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

        /**
         * Copy to local
         */
        $uniqid = uniqid();
        $this->tempDir = '/vagrant/application/web/tmp';
        $source = $image->copyToLocal($uniqid . '.jpg', $this->tempDir);
        $optimized = $image->copyToLocal($uniqid . '-optimized.jpg', $this->tempDir);

        /**
         * Optimize
         */
        $safeSourcePath = escapeshellarg($source->getPath());
        $safeOptimizedPath = escapeshellarg($optimized->getPath());
        $safeQuality = escapeshellarg($this->quality);

        $cmd = $this->mozJpgPath . ' -outfile ' . $safeOptimizedPath . '  -quality ' . $safeQuality . ' ' . $safeSourcePath;
        exec($cmd);

        /**
         * Replace Image
         */
        if($source->getSize() > $optimized->getSize()){
            $image->load($optimized->read());
        }

        /**
         * Cleanup
         */
        $source->delete();
        $optimized->delete();
    }
}