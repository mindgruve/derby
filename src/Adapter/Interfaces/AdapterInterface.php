<?php

namespace Derby\Adapter\Interfaces;

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

}
