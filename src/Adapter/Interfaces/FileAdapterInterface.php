<?php

namespace Derby\Adapter\Interfaces;

use Derby\AdapterInterface;

interface FileAdapterInterface extends AdapterInterface
{

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
