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
     * @return MediaInterface
     */
    public function getMedia($key);

}
