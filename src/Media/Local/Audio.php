<?php

namespace Derby\Media\Local;

use Derby\Media\Local;

class Audio extends File
{

    const TYPE_MEDIA_FILE_AUDIO = 'MEDIA\FILE\AUDIO';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_AUDIO;
    }
}
