<?php

namespace Derby\Media\LocalFile;

use Derby\Media\LocalFile;

class Presentation extends LocalFile
{
    const TYPE_MEDIA_FILE_PRESENTATION = 'MEDIA\LOCAL\PRESENTATION';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_PRESENTATION;
    }
}
