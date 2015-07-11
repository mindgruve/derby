<?php

namespace Derby\Media\LocalFile;

use Derby\Media\LocalFile;

class Document extends LocalFile
{
    const TYPE_MEDIA_FILE_DOCUMENT = 'MEDIA/LOCAL_FILE/DOCUMENT';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_DOCUMENT;
    }
}
