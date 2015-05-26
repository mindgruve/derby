<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\LocalFileFactory;

use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Media\AbstractLocalFileFactory;
use Derby\Media\LocalFile;

/**
 * Derby\Media\LocalFileFactory\LocalFactory
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class LocalFactory extends AbstractLocalFileFactory
{
    /**
     * {@inheritDoc}
     */
    public function build($key, LocalFileAdapterInterface $adapter)
    {
        return new LocalFile($key, $adapter);
    }
}