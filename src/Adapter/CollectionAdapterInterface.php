<?php

namespace Derby\Adapter;

use Derby\AdapterInterface;
use Derby\MediaInterface;

interface CollectionAdapterInterface extends AdapterInterface
{
    /**
     * Returns back the items (paginated)
     * @param $key
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function getItems($key, $page = 1, $limit = 10);

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
