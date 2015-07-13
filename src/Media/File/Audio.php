<?php

namespace Derby\Media\File;

use Derby\Media\File;

class Audio extends File
{

    const TYPE_MEDIA_FILE_AUDIO = 'MEDIA/FILE/AUDIO';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_AUDIO;
    }
}
