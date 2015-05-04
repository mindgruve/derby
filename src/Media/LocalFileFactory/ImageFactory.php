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
use Derby\Media\LocalFile\Image;
use Imagine\Gd\Imagine;

/**
 * Derby\Media\LocalFileFactory\ImageFactory
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class ImageFactory extends AbstractLocalFileFactory
{
    /**
     * {@inheritDoc}
     */
    public function build($key, LocalFileAdapterInterface $adapter)
    {
        return new Image($key, $adapter, new Imagine());
    }
}