<?php

namespace Derby\Media\LocalFile;

use Derby\Media\LocalFile;

class Document extends LocalFile
{
    const TYPE_MEDIA_FILE_DOCUMENT = 'MEDIA\LOCAL\DOCUMENT';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_DOCUMENT;
    }
}
