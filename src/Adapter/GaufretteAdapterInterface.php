<?php

namespace Derby\Adapter;

use Derby\AdapterInterface;
use Gaufrette\Adapter;

interface GaufretteAdapterInterface extends AdapterInterface
{
    /**
     * Get gaufrette adapter
     * @return Adapter
     */
    public function getGaufretteAdapter();

    /**
     * Set gaufrette adapter
     * @param Adapter $adapter
     * @return mixed
     */
    public function setGaufretteAdapter(Adapter $adapter);

    /**
     * @param $key
     * @return mixed
     */
    public function delete($key);

    /**
     * @param $sourceKey
     * @param $targetKey
     * @return mixed
     */
    public function rename($sourceKey, $targetKey);

    /**
     * @param $key
     * @param $data
     * @return mixed
     */
    public function write($key, $data);

    /**
     * @param $key
     * @return mixed
     */
    public function read($key);

}
