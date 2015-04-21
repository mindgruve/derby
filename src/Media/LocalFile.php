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
 * Derby\Media\LocalFile
 *
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class LocalFile implements LocalFileInterface
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
     * @param $data
     * @return mixed
     */
    public function write($data)
    {
        // TODO: Implement write() method.
    }

    /**
     * @return boolean
     */
    public function read()
    {
        // TODO: Implement read() method.
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

    /**
     * @return string
     */
    public function getMimeType()
    {
        // TODO: Implement getMimeType() method.
    }

    /**
     * @param $mimeType
     * @return $this
     */
    public function setMimeType($mimeType)
    {
        // TODO: Implement setMimeType() method.
    }

    /**
     * @param AdapterInterface $adapter
     * @return RemoteFileInterface
     */
    public function upload(AdapterInterface $adapter)
    {
        // TODO: Implement upload() method.
    }
}
