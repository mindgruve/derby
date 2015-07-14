<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\File\Factory;

use Derby\Adapter\FileAdapterInterface;
use Derby\Media\File\Video;

/**
 * Derby\Media\LocalFileFactory\VideoFactory
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class VideoFactory extends FileFactory
{
    /**
     * {@inheritDoc}
     */
    public function build($key, FileAdapterInterface $adapter)
    {
        return new Video($key, $adapter);
    }

    /**
     * @param array $extensions
     */
    public function __construct(array $extensions)
    {
        $this->setExtensions($extensions);
    }
}