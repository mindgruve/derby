<?php

namespace Derby\Adapter;

use Derby\MediaInterface;

interface AdapterInterface
{

    /**
     * @param $key
     * @return boolean
     */
    public function exists($key);

    /**
     * @return string
     */
    public function getAdapterType();

    /**
     * @param $key
     * @return MediaInterface
     */
    public function getMedia($key);

    /**
     * @param $adapterKey
     * @return $this
     */
    public function setAdapterKey($adapterKey);

    /**
     * @return string
     */
    public function getAdapterKey();

}
