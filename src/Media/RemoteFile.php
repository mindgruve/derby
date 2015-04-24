<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media;

use Derby\Adapter\RemoteFileAdapterInterface;
use Derby\Media;
use Derby\MediaInterface;
use Derby\AdapterInterface;

/**
 * Derby\Media\RemoteFile
 *
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class RemoteFile extends Media implements RemoteFileInterface
{
    public function __construct($key, RemoteFileAdapterInterface $adapter)
    {
        parent::__construct($key, $adapter);
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::TYPE_MEDIA_REMOTE_FILE;
    }

    /**
     * Read data from file
     * @return string|boolean if cannot read content
     */
    public function read()
    {
        // TODO: Implement read() method.
    }

    /**
     * Write data to file
     * @param $data
     * @return integer|boolean The number of bytes that were written into the file
     */
    public function write($data)
    {
        $this->adapter->write($this->key, $data);
    }

    /**
     * Indicates whether the file exists
     * @return boolean
     */
    public function exists()
    {
        // TODO: Implement exists() method.
    }

    /**
     * Delete file
     * @return boolean
     */
    public function delete()
    {
        // TODO: Implement delete() method.
    }

    /**
     * Rename/move file
     *
     * @param $newKey
     * @return boolean
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

}
