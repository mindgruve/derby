<?php

namespace Derby\Media;

use Derby\Adapter\CollectionAdapterInterface;
use Derby\Media;
use Derby\MediaInterface;
use SplObjectStorage;
use Iterator;

class Group extends Media implements GroupInterface
{

    /**
     * @var string
     */
    protected $key;

    /**
     * @var CollectionAdapterInterface
     */
    protected $adapter;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var SplObjectStorage
     */
    protected $items;

    public function __construct(
        $key,
        CollectionAdapterInterface $adapter,
        array $options = array()
    ) {
        $this->key     = $key;
        $this->adapter = $adapter;
        $this->options = $options;
        $this->items   = new SplObjectStorage();
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::MEDIA_COLLECTION;
    }


    /**
     * @param array $items
     * @return $this
     */
    public function addAll(array $items)
    {
        foreach ($items as $item) {
            $this->items->attach($item);
        }

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
     * @param array $items
     * @return $this
     */
    public function removeAll(array $items)
    {
        foreach ($items as $item) {
            $this->items->detach($item);
        }

        return $this;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function removeAllExcept(array $items)
    {
        $objSpl = new SplObjectStorage();
        foreach ($items as $item) {
            $objSpl->attach($item);
        }
        $this->items->removeAllExcept($objSpl);

        return $this;
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
