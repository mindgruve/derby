<?php

namespace Derby\Media;

use Derby\Adapter\GaufretteAdapterInterface;
use Derby\Media;

class File extends Media implements FileInterface
{

    /**
     * @var string
     */
    protected $key;

    /**
     * @var GaufretteAdapterInterface
     */
    protected $adapter;

    /**
     * @var array
     */
    protected $options;

    public function __construct(
        $key,
        GaufretteAdapterInterface $adapter,
        array $options = array()
    ) {
        $this->key     = $key;
        $this->adapter = $adapter;
        $this->options = $options;
    }


    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return bool
     */
    public function remove()
    {
        return $this->adapter->delete($this);
    }

    /**
     * @return boolean
     */
    public function read()
    {
        return $this->adapter->read($this->getKey());
    }

    /**
     * @param $data
     * @return mixed
     */
    public function write($data)
    {
        return $this->adapter->write($this->getKey(), $data);
    }

    /**
     * @param $newKey
     * @return bool
     */
    public function rename($newKey)
    {
        return $this->adapter->rename($this->getKey(), $newKey);
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

}
