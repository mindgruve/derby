<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media;

use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Adapter\RemoteFileAdapterInterface;
use Derby\Media;
use Gaufrette\Adapter\Local;

/**
 * Derby\Media\LocalFile
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
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
        return self::TYPE_MEDIA_LOCAL_FILE;
    }

    /**
     * {@inheritDoc}
     */
    public function read()
    {
        return $this->adapter->read($this->key);
    }

    /**
     * {@inheritDoc}
     */
    public function write($data)
    {
        return $this->adapter->write($this->key, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function exists()
    {
        return $this->adapter->exists($this->key);
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {
        return $this->adapter->delete($this->key);
    }

    /**
     * {@inheritDoc}
     */
    public function rename($newKey)
    {
        $success = $this->adapter->rename($this->key, $newKey);

        if ($success) {
            $this->key = $newKey;
        }

        return $success;
    }

    /**
     * {@inheritDoc}
     */
    public function getFileExtension()
    {
        // @todo we are going to want make this smarter. A "." should be the last char followed by letters.

        if (strpos($this->key, '.') === false) {
            return null;
        }

        return substr($this->key, strrpos($this->key, '.') + 1, strlen($this->key));
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
    public function getSize()
    {
        if (!$this->exists()) {
            return null;
        }

        return filesize($this->getPath());
    }

    /**
     * {@inheritDoc}
     */
    public function getPath($key = null)
    {
        return $this->adapter->getPath($key ?: $this->key);
    }
}
