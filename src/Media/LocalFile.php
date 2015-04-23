<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media;

use Derby\Adapter\GaufretteAdapterInterface;
use Derby\Adapter\LocalFileAdapter;
use Derby\Adapter\LocalFileAdapterInterface;
use Derby\AdapterInterface;
use Derby\MediaInterface;
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
     * @return string
     */
    public function getMediaType()
    {
        // TODO: Implement getMediaType() method.
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
     * @param AdapterInterface $adapter
     * @return RemoteFileInterface
     */
    public function upload(AdapterInterface $adapter)
    {
        // TODO: Implement upload() method.
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        return substr($this->key, strrpos($this->key, '.'), strlen($this->key));
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->adapter->getGaufretteAdapter()->mimeType($this->key);
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        // I'm sure this can be optimized!
        // We're just accounting for leading or trailing /'s

        $base = $this->adapter->getBaseDirectory();
        $baselen = strlen($base);

        if (strrpos($base, '/') === (int)$baselen-1) {
            $base = substr($base, 0, $baselen-1);
        }

        $file = $this->key;
        if ($pos = strpos($file, '/') === (int)0) {
            $file = substr($file, $pos, strlen($file));
        }

        return $base.'/'.$file;
    }
}
