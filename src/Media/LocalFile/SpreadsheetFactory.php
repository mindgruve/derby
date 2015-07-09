<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\LocalFile;

use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Media\LocalFile\Spreadsheet;

/**
 * Derby\Media\LocalFileFactory\SpreadsheetFactory
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class SpreadsheetFactory extends AbstractFileFactory
{
    /**
     * {@inheritDoc}
     */
    public function build($key, LocalFileAdapterInterface $adapter)
    {
        return new Spreadsheet($key, $adapter);
    }

    /**
     * @param array $extensions
     * @param array $mimetypes
     */
    public function __construct(array $extensions, array $mimetypes)
    {
        $this->setExtensions($extensions);
        $this->setMimeTypes($mimetypes);
    }
}