<?php

namespace Derby\Media\File;

use Derby\Media\File;

class Video extends File
{

    const TYPE_MEDIA_FILE_VIDEO = 'MEDIA/FILE/VIDEO';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_VIDEO;
    }

}
