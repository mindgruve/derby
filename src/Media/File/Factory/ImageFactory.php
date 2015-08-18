<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\File\Factory;

use Derby\Adapter\FileAdapterInterface;
use Derby\Media\File\Image;
use Imagine\Image\AbstractImagine;

/**
 * Derby\Media\LocalFileFactory\ImageFactory
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class ImageFactory extends FileFactory
{

    protected $imagine;

    /**
     * {@inheritDoc}
     */
    public function build($key, FileAdapterInterface $adapter)
    {
        return new Image($key, $adapter, $this->imagine);
    }

    /**
     * @param array $extensions
     * @param AbstractImagine $imagine
     */
    public function __construct(array $extensions,  AbstractImagine $imagine)
    {
        $this->imagine = $imagine;
        $this->setExtensions($extensions);
    }
}