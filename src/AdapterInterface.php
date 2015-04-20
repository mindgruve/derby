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

}
