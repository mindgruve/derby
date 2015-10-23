<?php

namespace Derby\EventListener;

use Derby\Event\ImagePostSave;
use Derby\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GenerateWebM implements EventSubscriberInterface
{
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
        /**
         * @todo
         */
    }
}