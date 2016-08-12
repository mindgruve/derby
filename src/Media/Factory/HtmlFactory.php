<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\Factory;

use Derby\Adapter\FileAdapterInterface;
use Derby\Media\File\Html;

/**
 * Derby\Media\LocalFileFactory\HtmlFactory
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class HtmlFactory extends FileFactory
{
    /**
     * {@inheritDoc}
     */
    public function build($key, FileAdapterInterface $adapter)
    {
        return new Html($key, $adapter);
    }

    /**
     * @param array $extensions
     */
    public function __construct(array $extensions)
    {
        $this->setExtensions($extensions);
    }
}