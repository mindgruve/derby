<?php

namespace Derby\Media;

use Derby\MediaInterface;
use SplObjectStorage;
use Countable;
use Iterator;
use Serializable;
use ArrayAccess;


interface CollectionInterface extends MediaInterface, Countable, Iterator, Serializable, ArrayAccess
{

    const MEDIA_COLLECTION = 'MEDIA\COLLECTION';

    /**
     * @return SplObjectStorage
     */
    public function getItems();

    /**
     * @param MediaInterface $item
     * @return $this
     */
    public function attach(MediaInterface $item);

    /**
     * @param CollectionInterface $collection
     * @return $this
     */
    public function addAll(CollectionInterface $collection);

    /**
     * @param MediaInterface $item
     * @return boolean
     */
    public function contains(MediaInterface $item);

    /**
     * @param MediaInterface $item
     * @return $this
     */
    public function detach(MediaInterface $item);

    /**
     * @return mixed
     */
    public function getInfo();

    /**
     * @param $data
     * @return mixed
     */
    public function setInfo($data);

    /**
     * @param $object
     * @return mixed
     */
    public function getHash(MediaInterface $object);

    /**
     * @param CollectionInterface $collection
     * @return $this
     */
    public function removeAll(CollectionInterface $collection);

    /**
     * @param CollectionInterface $collection
     * @return mixed
     */
    public function removeAllExcept(CollectionInterface $collection);

}
