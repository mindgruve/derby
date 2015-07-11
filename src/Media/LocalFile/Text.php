<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\LocalFile;

use Derby\Media\LocalFile;

/**
 * Derby\Media\LocalFile\Text
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class Text extends LocalFile
{
    const TYPE_MEDIA_FILE_TEXT = 'MEDIA/LOCAL_FILE/TEXT';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_TEXT;
    }

}