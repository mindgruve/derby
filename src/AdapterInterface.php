<?php

namespace Derby;

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

}
