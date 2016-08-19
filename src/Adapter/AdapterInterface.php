<?php

namespace Derby\Adapter;

use Derby\Media\MediaInterface;

interface AdapterInterface
{

    /**
     * @param $mediaKey
     * @return boolean
     */
    public function exists($mediaKey);

    /**
     * @param $mediaKey
     * @return MediaInterface
     */
    public function getMedia($mediaKey);

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
