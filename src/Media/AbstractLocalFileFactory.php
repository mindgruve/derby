<?php

/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media;

use Derby\Adapter\LocalFileAdapterInterface;
use Derby\AdapterInterface;
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
abstract class AbstractLocalFileFactory implements LocalFileFactoryInterface
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
     * @param array $extensions
     * @param array $mimetypes
     */
    public function __construct(array $extensions, array $mimetypes)
    {
        $this->setExtensions($extensions);
        $this->setMimeTypes($mimetypes);
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

        return $matchExt && $matchMimeType;
    }
}
