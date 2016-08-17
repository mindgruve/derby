<?php

namespace Derby\Adapter;

use Derby\AdapterInterface;
use Derby\MediaInterface;
use Derby\Cache\ResultPage;

interface CollectionAdapterInterface extends AdapterInterface
{
    /**
     * Returns the items
     * @param $key
     * @param int $limit
     * @param null $continuationToken
     * @return ResultPage
     */
    public function getItems($key, $limit=10, $continuationToken=null);

    /**
     * Returns the number of items in the collection
     * @param $key
     * @return int
     */
    public function count($key);

    /**
     * Returns back true if $item is in collection
     * @param $key
     * @param MediaInterface $item
     * @return boolean
     */
    public function contains($key, MediaInterface $item);

}
