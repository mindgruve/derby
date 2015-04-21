<?php

namespace Derby\Media\Local;

use Derby\Media\LocalFile;

class Audio extends LocalFile
{

    const TYPE_MEDIA_FILE_AUDIO = 'MEDIA\LOCAL\AUDIO';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_AUDIO;
    }
}
