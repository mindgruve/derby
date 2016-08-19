<?php

namespace Derby\Media;

use Countable;
use Derby\Cache\ResultPage;


interface CollectionInterface extends MediaInterface, Countable
{

    /**
     * @param int $limit
     * @param $continuationToken
     * @return ResultPage
     */
    public function getItems($limit = 10, $continuationToken);

    /**
     * @param MediaInterface $item
     * @return $this
     */
    public function add(MediaInterface $item);

    /**
     * @param MediaInterface $item
     * @return boolean
     */
    public function contains(MediaInterface $item);

    /**
     * @param MediaInterface $item
     * @return $this
     */
    public function remove(MediaInterface $item);

}
