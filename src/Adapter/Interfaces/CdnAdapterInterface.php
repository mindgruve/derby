<?php

namespace Derby\Adapter\Interfaces;

interface CdnAdapterInterface extends AdapterInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function getUrl($key);

}
