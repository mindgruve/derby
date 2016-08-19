<?php

namespace Derby\Adapter;

use Derby\Media\MediaInterface;
use Derby\Cache\ResultPage;

interface CollectionAdapterInterface extends AdapterInterface
{
    /**
     * Returns the items
     * @param $mediaKey
     * @param int $limit
     * @param null $continuationToken
     * @return ResultPage
     */
    public function getItems($mediaKey, $limit=10, $continuationToken=null);

    /**
     * Returns the number of items in the collection
     * @param $mediaKey
     * @return int
     */
    public function count($mediaKey);

    /**
     * Returns back true if $item is in collection
     * @param $mediaKey
     * @param MediaInterface $item
     * @return boolean
     */
    public function contains($mediaKey, MediaInterface $item);

}
