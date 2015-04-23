<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media;

use Derby\Adapter\LocalFileAdapterInterface;
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
    public function read(&$output = null)
    {
        return $this->adapter->getGaufretteAdapter()->read($this->key);
    }

    /**
     * {@inheritDoc}
     */
    public function write($data, &$output = null)
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
    public function upload(AdapterInterface $adapter)
    {
        // TODO: Implement upload() method.
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
        // I'm sure this can be optimized!
        // We're just accounting for leading or trailing /'s

        $base = $this->adapter->getBaseDirectory();
        $baselen = strlen($base);

        if (strrpos($base, '/') === (int)$baselen-1) {
            $base = substr($base, 0, $baselen-1);
        }

        $key = $key ?: $this->key;
        if ($pos = strpos($key, '/') === (int)0) {
            $key = substr($key, $pos, strlen($key));
        }

        return $base.'/'.$key;
    }
}
