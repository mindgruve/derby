<?php

namespace Derby\Media;

use Derby\MediaInterface;

class Media implements  MediaInterface
{
    
    protected $metaData;


    public function __construct(
        MetaData $metaData
    ) {
        $this->metaData = $metaData;
    }
    
    public function getMediaType(){
        return self::TYPE_MEDIA;
    }

    /**
     * @return \Derby\Media\MetaData
     */
    public function getMetaData()
    {
        return $this->metaData;
    }


}
