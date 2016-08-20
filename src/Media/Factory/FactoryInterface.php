<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\Factory;

use Derby\Adapter\FileAdapterInterface;
use Derby\Media\FileInterface;
use Derby\Media\MediaInterface;
use Gaufrette\Adapter;

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
     * @param MediaInterface $file
     * @return mixed
     */
    public function supports(MediaInterface $file);

    /**
     * @param $mediaKey
     * @param FileAdapterInterface $adapter
     * @return mixed
     */
    public function build($mediaKey, FileAdapterInterface $adapter);
}