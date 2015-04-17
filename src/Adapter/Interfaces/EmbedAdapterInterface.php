<?php

namespace Derby\Adapter\Interfaces;

interface EmbedAdapterInterface extends AdapterInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function render($key);
    
}
