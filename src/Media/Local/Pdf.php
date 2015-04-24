<?php

namespace Derby\Media\Local;

use Derby\Media\LocalFile;

class Pdf extends LocalFile
{
    const TYPE_MEDIA_FILE_PDF = 'MEDIA\LOCAL\PDF';

    public function getMediaType()
    {

        return self::TYPE_MEDIA_FILE_PDF;
    }
}