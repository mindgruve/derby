<?php

namespace Derby\Media\LocalFile;

use Derby\Media\LocalFile;

class Audio extends LocalFile
{

    const TYPE_MEDIA_FILE_AUDIO = 'MEDIA/LOCAL_FILE/AUDIO';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_AUDIO;
    }
}
