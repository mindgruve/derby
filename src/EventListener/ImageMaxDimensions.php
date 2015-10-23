<?php

namespace Derby\EventListener;

use Derby\Event\ImagePreLoad;
use Derby\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ImageMaxDimensions implements EventSubscriberInterface
{

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::IMAGE_PRE_LOAD => array('onImagePreload', 0),
        );
    }

    public function onImagePreload(ImagePreLoad $e){
        /**
         * @todo
         */
    }

}