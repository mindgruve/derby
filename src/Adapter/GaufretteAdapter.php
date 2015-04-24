<?php

namespace Derby\Adapter;

use Derby\Config;
use Derby\Media\LocalFile;
use Derby\Media\LocalFileHelper;
use Gaufrette\Adapter;
use Gaufrette\Filesystem;

class GaufretteAdapter implements GaufretteAdapterInterface
{
    /**
     * Gaufrette adapter
     * @var Adapter
     */
    protected $gaufretteAdapter;

    const ADAPTER_TYPE_GAUFRETTE = 'ADAPTER\GAUFRETTE';

    /**
     * @param Adapter $gaufretteAdapter
     */
    public function __construct(Adapter $gaufretteAdapter)
    {
        $this->gaufretteAdapter = $gaufretteAdapter;
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
     * @param $key
     * @param $data
     * @return mixed
     */
    public function write($key, $data)
    {
        return $this->gaufretteAdapter->write($key, $data);
    }

    /**
     * Get media
     * @param $key
     * @return \Derby\MediaInterface
     */
    public function getMedia($key){
        if ($this instanceof LocalFileAdapterInterface) {
            return LocalFileHelper::create(Config::create())->buildMedia($key, $this);
        } else {
            // @todo
        }
    }
}
