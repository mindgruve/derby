<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media;

use Derby\MediaInterface;
use Derby\AdapterInterface;

/**
 * Derby\Media\RemoteFile
 *
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class RemoteFile implements RemoteFileInterface
{
    /**
     * @return string
     */
    public function getMediaType()
    {
        // TODO: Implement getMediaType() method.
    }

    /**
     * Set key
     * @param $key
     * @return MediaInterface
     */
    public function setKey($key)
    {
        // TODO: Implement setKey() method.
    }

    /**
     * Get key
     * @return string
     */
    public function getKey()
    {
        // TODO: Implement getKey() method.
    }

    /**
     * Get adapter
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        // TODO: Implement getAdapter() method.
    }

    /**
     * Set adapter
     * @param AdapterInterface $adapter
     * @return mixed
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        // TODO: Implement setAdapter() method.
    }

    /**
     * @return bool
     */
    public function remove()
    {
        // TODO: Implement remove() method.
    }

    /**
     * @param $newKey
     * @return mixed
     */
    public function rename($newKey)
    {
        // TODO: Implement rename() method.
    }

    /**
     * @return LocalFileInterface
     */
    public function download()
    {
        // TODO: Implement download() method.
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        // TODO: Implement getFileExtension() method.
    }

    /**
     * @param string
     * @return string
     */
    public function setFileExtension($extension)
    {
        // TODO: Implement setFileExtension() method.
    }
}
