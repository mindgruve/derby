<?php

namespace Derby\Media;

interface AliasInterface extends MediaInterface
{
    const TYPE_ALIAS = 'MEDIA\ALIAS';
    
    /**
     * @return MediaInterface
     */
    public function getTarget();
}
