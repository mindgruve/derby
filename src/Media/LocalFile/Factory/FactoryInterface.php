<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\LocalFile\Factory;

use Derby\Adapter\LocalFileAdapterInterface;
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
     * Set mimetypes this file supports
     * @param array $mimeTypes
     * @return mixed
     */
    public function setMimeTypes(array $mimeTypes);

    /**
     * Is the given media type supported
     * @param MediaInterface $media
     * @return mixed
     */
    public function supports(MediaInterface $media);

    /**
     * Build this file
     * @param $key
     * @param LocalFileAdapterInterface $adapter
     * @return mixed
     */
    public function build($key, LocalFileAdapterInterface $adapter);
}