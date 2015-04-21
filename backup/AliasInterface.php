<?php

namespace Derby\Media;

use Derby\MediaInterface;

interface AliasInterface extends MediaInterface
{
    const TYPE_ALIAS = 'MEDIA\ALIAS';
    
    /**
     * @return MediaInterface
     */
    public function getTarget();
}
