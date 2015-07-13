<?php

/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media\File;

use Derby\Adapter\FileAdapterInterface;
use Derby\Media\File;
use Derby\MediaInterface;

/**
 * Derby\Media\Provider
 *
 * This class and its children may go away after we have a service container
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class FileFactory implements FactoryInterface
{
    /**
     * Supported extensions
     * @var array
     */
    protected $extensions;

    /**
     * {@inheritDoc}
     */
    public function build($key, FileAdapterInterface $adapter)
    {
        return new File($key, $adapter);
    }

    /**
     * {@inheritDoc}
     */
    public function setExtensions(array $extensions)
    {
        $this->extensions = $extensions;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(MediaInterface $media)
    {

        if (!$media instanceof File) {
            return false;
        }

        $matchExt = false;
        foreach ($this->extensions as $extension) {
            if (fnmatch($extension, $media->getFileExtension())) {
                $matchExt = true;
            }
        }


        return $matchExt;
    }
}
