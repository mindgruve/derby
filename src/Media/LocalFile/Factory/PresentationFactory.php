<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\LocalFile\Factory;

use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Media\LocalFile\Presentation;

/**
 * Derby\Media\LocalFileFactory\PresentationFactory
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class PresentationFactory extends AbstractFileFactory
{
    /**
     * {@inheritDoc}
     */
    public function build($key, LocalFileAdapterInterface $adapter)
    {
        return new Presentation($key, $adapter);
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