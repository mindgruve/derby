<?php

namespace Derby\Event;

use Derby\Media\File\Image;
use Symfony\Component\EventDispatcher\Event;

class ImagePreLoadFile extends Event
{
    /**
     * @var Image
     */
    protected $image;

    /**
     * @param Image $image
     */
    public function __construct(Image $image){
        $this->image = $image;
    }

    /**
     * @return Image
     */
    public function getImage(){
        return $this->image;
    }
}