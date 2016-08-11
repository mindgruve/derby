<?php

namespace Derby\Adapter;

use Derby\AdapterInterface;

interface CollectionAdapterInterface extends AdapterInterface
{
    /**
     * @param $key
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function getItems($key, $page = 1, $limit = 10);

}
