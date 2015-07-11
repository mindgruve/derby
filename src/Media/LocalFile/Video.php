<?php

namespace Derby\Media\LocalFile;

use Derby\Media\LocalFile;

class Video extends LocalFile
{

    const TYPE_MEDIA_FILE_VIDEO = 'MEDIA/LOCAL_FILE/VIDEO';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_VIDEO;
    }

}
