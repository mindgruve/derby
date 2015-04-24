<?php

namespace Derby\Adapter;

use Derby\Config;
use Gaufrette\Adapter;

abstract class AbstractGaufretteAdapter implements GaufretteAdapterInterface
{
    /**
     * Gaufrette adapter
     * @var Adapter
     */
    protected $gaufretteAdapter;

    /**
     * @var Config
     */
    private $config;

    const ADAPTER_TYPE_GAUFRETTE = 'ADAPTER\GAUFRETTE';

    /**
     * {@inheritDoc}
     */
    abstract public function getMedia($key);

    /**
     * @param Adapter $gaufretteAdapter
     */
    public function __construct(Adapter $gaufretteAdapter)
    {
        $this->gaufretteAdapter = $gaufretteAdapter;

        // create default config object
        $this->config = new Config();
    }

    /**
     * Get config
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set config
     * @param Config $config
     * @return self
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
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
     * @param $key
     * @param $data
     * @return mixed
     */
    public function write($key, $data)
    {
        return $this->gaufretteAdapter->write($key, $data);
    }
}
