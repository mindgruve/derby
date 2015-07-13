<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\File;

use Derby\Adapter\FileAdapterInterface;
use Derby\MediaInterface;

/**
 * Derby\Media\LocalFileFactoryInterface
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
interface FactoryInterface
{
    /**
     * Set extensions this file supports
     * @param array $extensions
     * @return mixed
     */
    public function setExtensions(array $extensions);

    /**
     * Is the given media type supported
     * @param MediaInterface $media
     * @return mixed
     */
    public function supports(MediaInterface $media);

    /**
     * Build this file
     * @param $key
     * @param FileAdapterInterface $adapter
     * @return mixed
     */
    public function build($key, FileAdapterInterface $adapter);
}