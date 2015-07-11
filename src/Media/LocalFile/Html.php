<?php

/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media\LocalFile;

use Derby\Media\LocalFile;

/**
 * Derby\Media\LocalFile\Html
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class Html extends LocalFile
{
    const TYPE_MEDIA_FILE_HTML = 'MEDIA/LOCAL_FILE/HTML';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_HTML;
    }

}
