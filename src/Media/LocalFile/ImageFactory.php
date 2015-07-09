<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\LocalFile;

use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Media\LocalFile\Image;
use Imagine\Gd\Imagine;
use Imagine\Image\AbstractImagine;

/**
 * Derby\Media\LocalFileFactory\ImageFactory
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class ImageFactory extends AbstractFileFactory
{

    protected $imagine;

    /**
     * {@inheritDoc}
     */
    public function build($key, LocalFileAdapterInterface $adapter)
    {
        return new Image($key, $adapter, $this->imagine);
    }

    /**
     * @param array $extensions
     * @param array $mimetypes
     */
    public function __construct(array $extensions, array $mimetypes, AbstractImagine $imagine)
    {
        $this->imagine = $imagine;
        $this->setExtensions($extensions);
        $this->setMimeTypes($mimetypes);
    }
}