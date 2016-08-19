<?php

namespace Derby\Adapter;

use Derby\Media\File;
use Gaufrette\Adapter;

class FileAdapter implements FileAdapterInterface
{

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
    public function getMedia($mediaKey)
    {
        return new File($mediaKey, $this);
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
     * @param $mediaKey
     * @return bool
     */
    public function exists($mediaKey)
    {
        return $this->gaufretteAdapter->exists($mediaKey);
    }

    /**
     * @param $mediaKey
     * @return mixed
     */
    public function read($mediaKey)
    {
        return $this->gaufretteAdapter->read($mediaKey);
    }

    /**
     * @param $mediaKey
     * @return mixed
     */
    public function delete($mediaKey)
    {
        return $this->gaufretteAdapter->delete($mediaKey);
    }

    /**
     * @param $sourceMediaKey
     * @param $targetMediaKey
     * @return mixed
     */
    public function rename($sourceMediaKey, $targetMediaKey)
    {
        return $this->gaufretteAdapter->rename($sourceMediaKey, $targetMediaKey);
    }

    /**
     * @param $sourceMediaKey
     * @param $targetMediaKey
     * @return bool|int
     */
    public function copy($sourceMediaKey, $targetMediaKey)
    {
        return $this->gaufretteAdapter->write($targetMediaKey, $this->gaufretteAdapter->read($sourceMediaKey));
    }

    /**
     * @param $mediaKey
     * @param $data
     * @return mixed
     */
    public function write($mediaKey, $data)
    {
        return $this->gaufretteAdapter->write($mediaKey, $data);
    }

}