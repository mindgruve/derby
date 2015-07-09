<?php

/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media\LocalFile\Factory;

use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Media\LocalFile;
use Derby\MediaInterface;

/**
 * Derby\Media\Provider
 *
 * This class and its children may go away after we have a service container
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
abstract class AbstractFileFactory implements FactoryInterface
{
    /**
     * Supported extensions
     * @var array
     */
    protected $extensions;

    /**
     * Supported mime types
     * @var array
     */
    protected $mimeTypes;

    /**
     * {@inheritDoc}
     */
    abstract public function build($key, LocalFileAdapterInterface $adapter);

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
    public function setMimeTypes(array $mimeTypes)
    {
        $this->mimeTypes  = $mimeTypes;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(MediaInterface $media)
    {

        if (!$media instanceof LocalFile) {
            return false;
        }
        
        $matchExt = false;
        foreach ($this->extensions as $extension) {
            if (fnmatch($extension, $media->getFileExtension())) {
                $matchExt = true;
            }
        }

        $matchMimeType = false;
        foreach ($this->mimeTypes as $mimeType) {
            if (fnmatch($mimeType, $media->getMimeType())) {
                $matchMimeType = true;
            }
        }

        return $media->getFileExtension() == ''
            ? $matchMimeType === true
            : ($matchExt && $matchMimeType) === true;
    }
}
