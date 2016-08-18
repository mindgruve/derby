<?php

namespace Derby\Adapter;

use Derby\Media\File;
use Gaufrette\Adapter;

class FileAdapter implements FileAdapterInterface
{

    const ADAPTER_TYPE_GAUFRETTE = 'ADAPTER\FILE';

    /**
     * Gaufrette adapter
     * @var Adapter
     */
    protected $gaufretteAdapter;

    /**
     * @var string
     */
    protected $adapterKey;

    /**
     * {@inheritDoc}
     */
    public function getMedia($key)
    {
        return new File($key, $this);
    }

    /**
     * @param $adapterKey
     * @param Adapter $gaufretteAdapter
     */
    public function __construct($adapterKey, Adapter $gaufretteAdapter)
    {
        $this->gaufretteAdapter = $gaufretteAdapter;
        $this->adapterKey = $adapterKey;
    }

    /**
     * @return mixed
     */
    public function getAdapterKey()
    {
        return $this->adapterKey;
    }

    /**
     * @param $adapterKey
     * @return $this
     */
    public function setAdapterKey($adapterKey)
    {
        $this->adapterKey = $adapterKey;

        return $this;
    }


    /**
     * Get gaufrette adapter
     * @return Adapter
     */
    public function getGaufretteAdapter()
    {
        return $this->gaufretteAdapter;
    }

    /**
     * Set gaufrette adapter
     * @param Adapter $gaufretteAdapter
     * @return mixed
     */
    public function setGaufretteAdapter(Adapter $gaufretteAdapter)
    {
        $this->gaufretteAdapter = $gaufretteAdapter;
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
        return $this->gaufretteAdapter->exists($key);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function read($key)
    {
        return $this->gaufretteAdapter->read($key);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function delete($key)
    {
        return $this->gaufretteAdapter->delete($key);
    }

    /**
     * @param $sourceKey
     * @param $targetKey
     * @return mixed
     */
    public function rename($sourceKey, $targetKey)
    {
        return $this->gaufretteAdapter->rename($sourceKey, $targetKey);
    }

    /**
     * @param $sourceKey
     * @param $targetKey
     * @return bool|int
     */
    public function copy($sourceKey, $targetKey)
    {
        return $this->gaufretteAdapter->write($targetKey, $this->gaufretteAdapter->read($sourceKey));
    }

    /**
     * @param $key
     * @param $data
     * @return mixed
     */
    public function write($key, $data)
    {
        return $this->gaufretteAdapter->write($key, $data);
    }

}