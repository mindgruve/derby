<?php

namespace Derby\Adapter;

use Gaufrette\Adapter;

interface FileAdapterInterface extends AdapterInterface
{

    /**
     * Get gaufrette adapter
     * @return Adapter
     */
    public function getGaufretteAdapter();

    /**
     * Set gaufrette adapter
     * @param Adapter $gaufretteAdapter
     * @return mixed
     */
    public function setGaufretteAdapter(Adapter $gaufretteAdapter);

    /**
     * @param $mediaKey
     * @return mixed
     */
    public function delete($mediaKey);

    /**
     * @param $sourceKey
     * @param $targetKey
     * @return mixed
     */
    public function rename($sourceKey, $targetKey);

    /**
     * @param $sourceKey
     * @param $targetKey
     * @return bool|int
     */
    public function copy($sourceKey, $targetKey);

    /**
     * @param $mediaKey
     * @param $data
     * @return mixed
     */
    public function write($mediaKey, $data);

    /**
     * @param $mediaKey
     * @return mixed
     */
    public function read($mediaKey);

}