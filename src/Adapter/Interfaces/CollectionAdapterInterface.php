<?php

namespace Derby\Adapter\Interfaces;

use Derby\AdapterInterface;

interface CollectionAdapterInterface extends AdapterInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function listItems($key);
    
}
