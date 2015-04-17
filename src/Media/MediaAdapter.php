<?php

namespace Derby\Media;

use Derby\Adapter\Interfaces\AdapterInterface;
use Derby\Adapter\Interfaces\CdnAdapterInterface;
use Derby\Adapter\Interfaces\CollectionAdapterInterface;
use Derby\Adapter\Interfaces\EmbedAdapterInterface;
use Derby\Adapter\Interfaces\FileAdapterInterface;
use Derby\Adapter\Interfaces\ImageAdapterInterface;
use Derby\Exception\UnsupportedMethodException;

class MediaAdapter
{

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return string
     */
    public function getAdapterType()
    {
        return $this->adapter->getAdapterType();
    }

    /**
     * @return string
     * @throws UnsupportedMethodException
     */
    public function render($key)
    {
        if($this->adapter instanceof EmbedAdapterInterface){
            return $this->adapter->render($key);
        }

        throw new UnsupportedMethodException();
    }

    /**
     * @param $key
     * @return string
     * @throws UnsupportedMethodException
     */
    public function getUrl($key)
    {
        if($this->adapter instanceof CdnAdapterInterface){
            return $this->adapter->getUrl($key);
        }

        throw new UnsupportedMethodException();
    }

    /**
     * @param $height
     * @param null $width
     * @param null $quality
     * @param string $mode
     * @return string
     * @throws UnsupportedMethodException
     */
    public function resize($height, $width = null, $quality = null, $mode = null)
    {
        if($this->adapter instanceof ImageAdapterInterface){
            return $this->adapter->resize($height, $width, $quality, $mode);
        }

        throw new UnsupportedMethodException();
    }
    
    /**
     * @param string $key
     * @return string
     * @throws UnsupportedMethodException
     */
    public function read($key)
    {
        if($this->adapter instanceof FileAdapterInterface){
            return $this->adapter->read($key);
        }

        throw new UnsupportedMethodException();
    }

    /**
     * @param $key
     * @param $data
     * @return mixed
     * @throws UnsupportedMethodException
     */
    public function write($key, $data)
    {
        if($this->adapter instanceof FileAdapterInterface){
            return $this->adapter->write($key, $data);
        }

        throw new UnsupportedMethodException();
    }

    /**
     * @param string $key
     * @return bool
     * @throws UnsupportedMethodException
     */
    public function delete($key)
    {
        if($this->adapter instanceof FileAdapterInterface){
            return $this->adapter->delete($key);
        }

        throw new UnsupportedMethodException();
    }

    /**
     * @param string $sourceKey
     * @param string $targetKey
     * @return bool
     * @throws UnsupportedMethodException
     */
    public function rename($sourceKey, $targetKey)
    {
        if($this->adapter instanceof FileAdapterInterface){
            return $this->adapter->rename($sourceKey, $targetKey);
        }
        
        throw new UnsupportedMethodException();
    }


    /**
     * @param $key
     * @return mixed
     * @throws UnsupportedMethodException
     */
    public function listItems($key)
    {
        if($this->adapter instanceof CollectionAdapterInterface){
            return $this->adapter->listItems($key);
        }

        throw new UnsupportedMethodException();
    }

}
