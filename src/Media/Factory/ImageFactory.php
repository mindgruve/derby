<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\Factory;

use Derby\Adapter\FileAdapterInterface;
use Derby\Media\File\Image;
use Imagine\Image\AbstractImagine;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Derby\Media\LocalFileFactory\ImageFactory
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class ImageFactory extends FileFactory
{
    /**
     * @var AbstractImagine
     */
    protected $imagine;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * {@inheritDoc}
     */
    public function build($key, FileAdapterInterface $adapter)
    {
        return new Image($key, $adapter, $this->imagine, $this->dispatcher);
    }

    /**
     * @param array $extensions
     * @param AbstractImagine $imagine
     */
    public function __construct(array $extensions,  AbstractImagine $imagine, EventDispatcherInterface $dispatcher = null)
    {
        $this->imagine = $imagine;
        $this->dispatcher = $dispatcher;
        $this->setExtensions($extensions);
    }
}