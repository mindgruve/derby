<?php

namespace Derby\Media;

use Derby\MediaInterface;
use SplObjectStorage;
use Countable;
use Iterator;
use Serializable;
use ArrayAccess;


interface CollectionInterface extends MediaInterface, Countable
{

    /**
     * @return array
     */
    public function getItems($page = 1, $limit = 10);

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
