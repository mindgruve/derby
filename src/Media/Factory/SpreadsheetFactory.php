<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\Factory;

use Derby\Adapter\FileAdapterInterface;
use Derby\Media\File\Spreadsheet;

/**
 * Derby\Media\LocalFileFactory\SpreadsheetFactory
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class SpreadsheetFactory extends FileFactory
{
    /**
     * {@inheritDoc}
     */
    public function build($mediaKey, FileAdapterInterface $adapter)
    {
        return new Spreadsheet($mediaKey, $adapter);
    }

    /**
     * @param array $extensions
     */
    public function __construct(array $extensions)
    {
        $this->setExtensions($extensions);
    }
}