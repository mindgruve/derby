<?php

namespace Derby\Media\File;

use Derby\Media\File;

class Document extends File
{
    const TYPE_MEDIA_FILE_DOCUMENT = 'MEDIA\FILE\DOCUMENT';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_DOCUMENT;
    }
}
