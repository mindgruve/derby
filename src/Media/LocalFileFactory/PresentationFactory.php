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
use Derby\Media\LocalFile\Presentation;

/**
 * Derby\Media\LocalFileFactory\PresentationFactory
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class PresentationFactory extends AbstractLocalFileFactory
{
    /**
     * {@inheritDoc}
     */
    public function build($key, LocalFileAdapterInterface $adapter)
    {
        return new Presentation($key, $adapter);
    }
}