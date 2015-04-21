<?php

namespace Derby\Media\File;

use Derby\Media\LocalFile;

class Pdf extends LocalFile
{
    const TYPE_MEDIA_FILE_PDF = 'MEDIA\LOCAL\PDF';

    public function getMediaType()
    {

        return self::TYPE_MEDIA_FILE_PDF;
    }
}