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
            Events::IMAGE_PRE_SAVE => array('onImagePreSave', 0),
        );
    }

    public function onImagePreSave(ImagePreSave $e){
        /**
         * @todo
         */
    }
}