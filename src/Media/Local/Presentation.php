<?php

namespace Derby\Media\Local;

use Derby\Media\Local;

class Presentation extends File
{
    const TYPE_MEDIA_FILE_PRESENTATION = 'MEDIA\FILE\PRESENTATION';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_PRESENTATION;
    }
}
