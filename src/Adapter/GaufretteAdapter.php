<?php

namespace Derby\Adapter;

use Derby\Media\LocalFile;
use Derby\LocalMediaHelper;
use Gaufrette\Adapter;
use Gaufrette\Filesystem;

class GaufretteAdapter implements GaufretteAdapterInterface
{
    /**
     * Gaufrette adapter
     * @var Adapter
     */
    protected $adapter;

    const ADAPTER_TYPE_GAUFRETTE = 'ADAPTER\GAUFRETTE';

    /**
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get gaufrette adapter
     * @return Adapter
     */
    public function getGaufretteAdapter()
    {
        return $this->adapter;
    }

    /**
     * Set gaufrette adapter
     * @param Adapter $adapter
     * @return mixed
     */
    public function setGaufretteAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return string
     */
    public function getAdapterType()
    {
        return self::ADAPTER_TYPE_GAUFRETTE;
    }

    /**
     * @param $key
     * @return bool
     */
    public function exists($key)
    {
        return $this->adapter->exists($key);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function read($key)
    {
        return $this->adapter->read($key);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function delete($key)
    {
        return $this->adapter->delete($key);
    }

    /**
     * @param $sourceKey
     * @param $targetKey
     * @return mixed
     */
    public function rename($sourceKey, $targetKey)
    {
        return $this->adapter->rename($sourceKey, $targetKey);
    }

    /**
     * @param $key
     * @param $data
     * @return mixed
     */
    public function write($key, $data)
    {
        return $this->adapter->write($key, $data);
    }

    /**
     * Get media
     * @param $key
     * @return \Derby\MediaInterface
     */
    public function getMedia($key){
        if ($this instanceof LocalFileAdapterInterface) {
            return LocalMediaHelper::create()->buildMedia($key, $this);
        } else {
            // @todo
        }
    }
}
