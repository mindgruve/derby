<?php

namespace Derby\Media;

use Derby\Adapter\FileAdapterInterface;
use Derby\Media;

class File extends Media implements FileInterface
{

    /**
     * @var string
     */
    protected $key;

    /**
     * @var FileAdapterInterface
     */
    protected $adapter;

    /**
     * @var array
     */
    protected $options;

    public function __construct(
        $key,
        FileAdapterInterface $adapter,
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

}
