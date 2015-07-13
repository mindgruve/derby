<?php

/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media\File;

use Derby\Media\File;

/**
 * Derby\Media\LocalFile\Html
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class Html extends File
{
    const TYPE_MEDIA_FILE_HTML = 'MEDIA/FILE/HTML';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_HTML;
    }

}
