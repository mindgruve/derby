<?php

namespace Derby\Media;

use Derby\Media;
use Derby\MediaInterface;
use SplObjectStorage;

class Collection extends Media implements CollectionInterface
{

    /**
     * @var SplObjectStorage
     */
    protected $items;

    public function __construct(
        SplObjectStorage $items = null,
        MetaData $metaData
    ) {
        $this->items = $items;
        if (!$items) {
            $this->items = new SplObjectStorage();
        }

        parent::__construct($metaData);
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::MEDIA_COLLECTION;
    }


    /**
     * @param CollectionInterface $collection
     * @return $this
     */
    public function addAll(CollectionInterface $collection)
    {
        $this->items->addAll($collection->getItems());

        return $this;
    }

    /**
     * @param MediaInterface $item
     * @return $this
     */
    public function attach(MediaInterface $item)
    {
        $this->items->attach($item);

        return $this;
    }

    /**
     * @param MediaInterface $item
     * @return boolean
     */
    public function contains(MediaInterface $item)
    {
        return $this->items->contains($item);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->items->count();
    }

    /**
     * @return object
     */
    public function current()
    {
        return $this->items->current();
    }

    /**
     * @param MediaInterface $item
     * @return $this
     */
    public function detach(MediaInterface $item)
    {
        $this->items->detach($item);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->items->getInfo();
    }

    /**
     * @return $this
     */
    public function setInfo($data)
    {
        $this->items->setInfo($data);

        return $this;
    }


    /**
     * @return SplObjectStorage
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param $object
     * @return mixed
     */
    public function getHash(MediaInterface $object)
    {
        return $this->items->getHash($object);
    }


    /**
     * @return int
     */
    public function key()
    {
        return $this->items->key();
    }

    /**
     * @return void
     */
    public function next()
    {

        $this->items->next();
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->items->offsetExists($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->items->offsetGet($offset);
    }

    /**
     * @param mixed $object
     * @param mixed $data
     */
    public function offsetSet($object, $data)
    {
        $this->items->offsetSet($object, $data);
    }

    /**
     * @param mixed $object
     */
    public function offsetUnset($object)
    {
        $this->items->offsetUnset($object);
    }

    /**
     * @return $this
     */
    public function removeAll(CollectionInterface $collection)
    {
        $this->items->removeAll($collection->getItems());

        return $this;
    }

    /**
     * @param CollectionInterface $collection
     * @return mixed
     */
    public function removeAllExcept(CollectionInterface $collection)
    {
        $this->items->removeAllExcept($collection->getItems());
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->items->rewind();
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return $this->items->serialize();
    }

    /**
     * @return void
     */
    public function unserialize($serialized)
    {
        $this->items->unserialize($serialized);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->items->valid();
    }
}
