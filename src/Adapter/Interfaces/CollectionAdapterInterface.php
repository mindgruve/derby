<?php

namespace Derby\Adapter\Interfaces;

interface CollectionAdapterInterface extends AdapterInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function listItems($key);
    
}
