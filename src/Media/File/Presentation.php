<?php

namespace Derby\Media\File;

use Derby\Media\File;

class Presentation extends File
{
    const TYPE_MEDIA_FILE_PRESENTATION = 'MEDIA/FILE/PRESENTATION';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_PRESENTATION;
    }
}
