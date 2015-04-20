<?php

namespace Derby;

interface MediaInterface
{

    // Object Type
    const TYPE_MEDIA = 'MEDIA';

    /**
     * @return string
     */
    public function getMediaType();

    /**
     * @return \Derby\Media\MetaData
     */
    public function getMetaData();
}
