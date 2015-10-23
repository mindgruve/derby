<?php

namespace Derby\EventListener;

use Derby\Event\ImagePreSave;
use Derby\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GifsicleOptimize implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::IMAGE_PRE_SAVE => array('onMediaImagePreSave', 0),
        );
    }

    public function onMediaImagePreSave(ImagePreSave $e){
        /**
         * @todo
         */
    }
}