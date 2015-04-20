<?php

namespace Derby\Adapter\Interfaces;

use Derby\AdapterInterface;

interface EmbedAdapterInterface extends AdapterInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function render($key);
    
}
