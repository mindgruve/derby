<?php

namespace Derby\Media\File;

use Derby\Media\File;

class Zip extends File
{
    const TYPE_MEDIA_FILE_ZIP = 'MEDIA/FILE/ZIP';

    public function getMediaType()
    {

        return self::TYPE_MEDIA_FILE_ZIP;
    }
}