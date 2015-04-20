<?php

namespace Derby\Adapter\Interfaces;

use Derby\AdapterInterface;

interface CdnAdapterInterface extends AdapterInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function getUrl($key);

}
