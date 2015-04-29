<?php

/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media\Factory;

use Derby\Media\LocalFile;
use Derby\MediaInterface;

/**
 * Derby\Media\Provider
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class LocalFileFactory
{
    protected $extensions;

    protected $mimeTypes;

    protected $factory;

    public function __construct(array $extensions, array $mimetypes, callable $factory)
    {
        $this->extensions = $extensions;
        $this->mimeTypes  = $mimetypes;
        $this->factory    = $factory;
    }

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

    public function build($key, $adapter)
    {
        $callable = $this->factory;
        
        return $callable($key, $adapter);
    }
}
