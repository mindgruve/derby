<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media\File\Factory;

use Derby\Adapter\FileAdapterInterface;
use Derby\Media\FileInterface;
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
     * @param FileInterface $file
     * @return mixed
     */
    public function supports(FileInterface $file);

    /**
     * @param $key
     * @param FileAdapterInterface $adapter
     * @return mixed
     */
    public function build($key, FileAdapterInterface $adapter);
}