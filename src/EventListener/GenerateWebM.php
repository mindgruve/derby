<?php

namespace Derby\EventListener;

use Derby\Event\ImagePostSave;
use Derby\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GenerateWebM implements EventSubscriberInterface
{
    /**
     * @var string
     */
    protected $cwebp;

    /**
     * @var string
     */
    protected $tempDir;

    public function __construct($cwebp = 'cwebp', $tempDir = '/tmp/derby')
    {
        $this->cwebp = $cwebp;
        $this->tempDir = $tempDir;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::IMAGE_PRE_SAVE => array('onMediaImagePostSave', 0),
        );
    }

    /**
     * @param ImagePostSave $e
     */
    public function onMediaImagePostSave(ImagePostSave $e)
    {
        $image = $e->getImage();

        if (!$this->cwebp) {
            return;
        }

        if ($image->getFileExtension() != 'jpg' && $image->getFileExtension() != 'jpeg' && $image->getFileExtension() != 'png') {
            return;
        }

        /**
         * Copy to local
         */
        $uniqid = uniqid();
        $source = $image->copyToLocal($uniqid . $image->getFileExtension(), $this->tempDir);
        $webp = $image->copyToLocal($uniqid . '-webp.jpg', $this->tempDir);

        /**
         * Optimize
         */
        $safeSourcePath = escapeshellarg($source->getPath());
        $safeOptimizedPath = escapeshellarg($webp->getPath());

        $cmd = $this->cwebp . ' ' . $safeSourcePath . ' -o ' . $safeOptimizedPath;
        exec($cmd);

        /**
         * Replace Image
         */
        if ($source->getSize() > $webp->getSize() && $webp->getSize() != 0) {
            $newKey = str_replace('.' . $image->getFileExtension(), '.webp', $image->getKey());
            $image->getAdapter()->write($newKey, $webp->read());

        }

        /**
         * Cleanup
         */
        $source->delete();
        $webp->delete();
    }
}