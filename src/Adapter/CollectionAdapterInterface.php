<?php

namespace Derby\Adapter;

use Derby\AdapterInterface;

interface CollectionAdapterInterface extends AdapterInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function listItems($key);
    
}
