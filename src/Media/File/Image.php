<?php

namespace Derby\Media\File;

use Derby\Media\File;

class Image extends File
{
    const TYPE_MEDIA_FILE_IMAGE = 'MEDIA\FILE\IMAGE';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_IMAGE;
    }
}
