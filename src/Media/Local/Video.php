<?php

namespace Derby\Media\Local;

use Derby\Media\LocalFile;

class Video extends LocalFile
{

    const TYPE_MEDIA_FILE_VIDEO = 'MEDIA/LOCAL/VIDEO';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_VIDEO;
    }

}
