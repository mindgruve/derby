<?php

namespace Derby;

interface AdapterInterface
{

    /**
     * @return string
     */
    public function getAdapterType();

    /**
     * @param $key
     * @return bool
     */
    public function exists($key);

    /**
     * @param $key
     * @return MediaInterface
     */
    public function getMedia($key);

}
