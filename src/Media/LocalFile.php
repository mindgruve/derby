<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media;

use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Adapter\RemoteFileAdapterInterface;
use Derby\AdapterInterface;
use Derby\Media;

/**
 * Derby\Media\LocalFile
 *
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class LocalFile extends Media implements LocalFileInterface
{
    /**
     * @param $key
     * @param LocalFileAdapterInterface $adapter
     */
    public function __construct($key, LocalFileAdapterInterface $adapter)
    {
        parent::__construct($key, $adapter);
    }

    /**
     * {@inheritDoc}
     */
    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE;
    }

    /**
     * {@inheritDoc}
     */
    public function read()
    {
        return $this->adapter->getGaufretteAdapter()->read($this->key);
    }

    /**
     * {@inheritDoc}
     */
    public function write($data)
    {
        return $this->adapter->getGaufretteAdapter()->write($this->key, $data);
    }

    /**
     * Indicates whether the file exists
     * @return boolean
     */
    public function exists()
    {
        return $this->adapter->getGaufretteAdapter()->exists($this->key);
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {
        return $this->adapter->getGaufretteAdapter()->delete($this->key);
    }

    /**
     * {@inheritDoc}
     */
    public function rename($newKey)
    {
        $success = $this->adapter->getGaufretteAdapter()->rename($this->key, $newKey);

        if ($success) {
            $this->key = $newKey;
        }

        return $success;
    }

    /**
     * {@inheritDoc}
     */
    public function upload(RemoteFileAdapterInterface $adapter)
    {
        $remote = new RemoteFile($this->key, $adapter);
        $remote->write($this->key, $this->read());

        return $remote;
    }

    /**
     * {@inheritDoc}
     */
    public function getFileExtension()
    {
        return substr($this->key, strrpos($this->key, '.')+1, strlen($this->key));
    }

    /**
     * {@inheritDoc}
     */
    public function getMimeType()
    {
        return $this->adapter->getGaufretteAdapter()->mimeType($this->key);
    }

    /**
     * {@inheritDoc}
     */
    public function getPath($key = null)
    {
        return $this->adapter->getPath($key ?: $this->key);
    }
}
