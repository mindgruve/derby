<?php

namespace Derby\Media;

use Derby\Media\MediaInterface;
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
