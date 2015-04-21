<?php

namespace Derby\Media\File;

use Derby\Media\Local;

class Pdf extends File
{
    const TYPE_MEDIA_FILE_PDF = 'MEDIA\FILE\PDF';
    
    public function getMediaType()
    {
        
        return self::TYPE_MEDIA_FILE_PDF;
    }
}
