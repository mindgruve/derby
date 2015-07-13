<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\File;

use Derby\Media\File;

/**
 * Derby\Media\LocalFile\Text
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class Text extends File
{
    const TYPE_MEDIA_FILE_TEXT = 'MEDIA/FILE/TEXT';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_TEXT;
    }

}