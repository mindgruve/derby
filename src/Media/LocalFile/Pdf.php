<?php

namespace Derby\Media\LocalFile;

use Derby\Media\LocalFile;

class Pdf extends LocalFile
{
    const TYPE_MEDIA_FILE_PDF = 'MEDIA/LOCAL_FILE/PDF';

    public function getMediaType()
    {

        return self::TYPE_MEDIA_FILE_PDF;
    }
}