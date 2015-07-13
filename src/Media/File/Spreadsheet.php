<?php

namespace Derby\Media\File;

use Derby\Media\File;

class Spreadsheet extends File
{

    const TYPE_MEDIA_FILE_SPREADSHEET = 'MEDIA/FILE/SPREADSHEET';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_SPREADSHEET;
    }
}
