<?php

namespace Derby\Adapter;

use Derby\Adapter\GaufretteAdapterInterface;
use Gaufrette\Adapter;

class GaufretteAdapter implements GaufretteAdapterInterface
{
    /**
     * @var Adapter;
     */
    protected $adapter;

    const ADAPTER_TYPE_GAUFRETTE = 'ADAPTER\GAUFRETTE';

    function __construct(Adapter $adapter)
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

    public function getMedia($key){
        return new File($key, $this);
    }
}
