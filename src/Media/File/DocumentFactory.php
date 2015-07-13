<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\File;

use Derby\Adapter\FileAdapterInterface;
use Derby\Media\File\Document;

/**
 * Derby\Media\LocalFileFactory\DocumentFactory
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class DocumentFactory extends FileFactory
{
    /**
     * {@inheritDoc}
     */
    public function build($key, FileAdapterInterface $adapter)
    {
        return new Document($key, $adapter);
    }

    /**
     * @param array $extensions
     */
    public function __construct(array $extensions)
    {
        $this->setExtensions($extensions);
    }
}