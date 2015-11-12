<?php

namespace Derby\EventListener;

use Derby\Event\ImagePreLoad;
use Derby\Events;
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
     * @param null $maxWidth
     * @param null $maxHeight
     */
    public function __construct($maxWidth = null, $maxHeight = null)
    {
        $this->maxHeight = (int)$maxHeight;
        $this->maxWidth = (int)$maxWidth;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::IMAGE_PRE_LOAD => array('onMediaImagePreload', 0),
        );
    }

    public function onMediaImagePreload(ImagePreLoad $e)
    {
        $image = $e->getImage();
        $localCopy = $image->copyToLocal();
        $localPath = $localCopy->getPath();

        $imageSize = getimagesize($localPath);

        var_dump($imageSize);
        exit;

    }

}