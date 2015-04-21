<?php

namespace Derby\Media\File;

use Derby\Media\LocalFile;

class Spreadsheet extends LocalFile
{

    const TYPE_MEDIA_FILE_SPREADSHEET = 'MEDIA/LOCAL/SPREADSHEET';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_SPREADSHEET;
    }
}
